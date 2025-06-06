<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\Admin\CategoryManagementModel;
use App\Models\CarModel;

class Categories extends BaseController
{
    protected $categoryModel;
    protected $carModel;
    
    public function __construct()
    {
        $this->categoryModel = new CategoryManagementModel();
        $this->carModel = new CarModel();
    }
    
    public function index()
    {
        $data = [
            'title' => 'Pengelolaan Kategori',
            'categories' => $this->categoryModel->getAllCategoriesWithCarCount()
        ];
        
        return view('admin/categories/index', $data);
    }
    
    public function show($id)
    {
        $categoryData = $this->categoryModel->getCategoryDetails($id);
        
        if (!$categoryData) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan');
        }
        
        $data = [
            'title' => 'Detail Kategori',
            'category_data' => $categoryData
        ];
        
        return view('admin/categories/show', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori Baru'
        ];
        
        return view('admin/categories/create', $data);
    }
    
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]|is_unique[categories.name]',
            'description' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($this->categoryModel->insert($data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan kategori');
        }
    }
    
    public function edit($id)
    {
        $category = $this->categoryModel->find($id);
        
        if (!$category) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak ditemukan');
        }
        
        $data = [
            'title' => 'Edit Kategori',
            'category' => $category
        ];
        
        return view('admin/categories/edit', $data);
    }
    
    public function update($id)
    {
        $rules = [
            'name' => "required|min_length[3]|max_length[100]",
            'description' => 'required'
        ];
        
        // Check if name is changed
        $oldCategory = $this->categoryModel->find($id);
        if ($oldCategory['name'] != $this->request->getPost('name')) {
            $rules['name'] .= '|is_unique[categories.name]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $data = [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($this->categoryModel->update($id, $data)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui kategori');
        }
    }
    
    public function delete($id)
    {
        // Check if category is used in cars
        $usedInCars = $this->carModel->where('category_id', $id)->countAllResults();
        
        if ($usedInCars > 0) {
            return redirect()->to('/admin/categories')->with('error', 'Kategori tidak dapat dihapus karena sedang digunakan oleh ' . $usedInCars . ' mobil');
        }
        
        if ($this->categoryModel->delete($id)) {
            return redirect()->to('/admin/categories')->with('success', 'Kategori berhasil dihapus');
        } else {
            return redirect()->to('/admin/categories')->with('error', 'Gagal menghapus kategori');
        }
    }
    
    public function search()
    {
        $keyword = $this->request->getGet('keyword');
        
        $data = [
            'title' => 'Hasil Pencarian Kategori',
            'categories' => $this->categoryModel->searchCategories($keyword),
            'keyword' => $keyword
        ];
        
        return view('admin/categories/search', $data);
    }
} 