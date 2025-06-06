<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\Admin\UserManagementModel;

class Users extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        $this->userModel = new UserManagementModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'User Management',
            'users' => $this->userModel->getUsersWithRentalCount()
        ];
        
        return view('admin/users/index', $data);
    }
    
    public function show($id)
    {
        $userData = $this->userModel->getUserDetails($id);
        
        if (!$userData) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail User',
            'user_data' => $userData
        ];
        
        return view('admin/users/show', $data);
    }
    
    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];
        
        return view('admin/users/edit', $data);
    }
    
    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'phone' => 'required',
            'address' => 'required',
            'role' => 'required|in_list[customer,admin]',
            'status' => 'required|in_list[active,inactive,suspended]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status')
        ];
        
        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/admin/users')->with('success', 'User berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user');
        }
    }
    
    public function delete($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }
        
        $db = \Config\Database::connect();
        $db->transBegin();
        
        try {
            // Delete related records in orders table
            $db->table('orders')->where('user_id', $id)->delete();
            
            // Delete related records in rentals table
            $db->table('rentals')->where('user_id', $id)->delete();
            
            // Delete related records in payments table (if it has user_id)
            if ($db->fieldExists('user_id', 'payments')) {
                $db->table('payments')->where('user_id', $id)->delete();
            }
            
            // Delete related records in reviews table (if it exists and has user_id)
            if ($db->tableExists('reviews') && $db->fieldExists('user_id', 'reviews')) {
                $db->table('reviews')->where('user_id', $id)->delete();
            }
            
            // Finally delete the user
            $this->userModel->delete($id);
            
            $db->transCommit();
            return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->to('/admin/users')->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }
    
    public function updateStatus()
    {
        $id = $this->request->getPost('user_id');
        $status = $this->request->getPost('status');
        
        if ($this->userModel->updateUserStatus($id, $status)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Status user berhasil diperbarui']);
        } else {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status user']);
        }
    }
    
    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        
        $data = [
            'title' => 'Hasil Pencarian User',
            'users' => $this->userModel->searchUsers($keyword),
            'keyword' => $keyword
        ];
        
        return view('admin/users/search', $data);
    }
} 