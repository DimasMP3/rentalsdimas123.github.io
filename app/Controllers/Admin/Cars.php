<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\BaseController;
use App\Models\CarModel;
use App\Models\CategoryModel;
use App\Models\CarDiscountModel;

class Cars extends BaseController
{
    protected $carModel;
    protected $categoryModel;
    protected $carDiscountModel;
    
    public function __construct()
    {
        $this->carModel = new CarModel();
        $this->categoryModel = new CategoryModel();
        $this->carDiscountModel = new CarDiscountModel();
        
        helper(['form', 'url', 'discount']);
    }
    
    public function index()
    {
        $data = [
            'title' => 'Manage Cars',
            'cars' => $this->carModel->findAll()
        ];
        
        return view('admin/cars/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Add New Car',
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('admin/cars/create', $data);
    }
    
    public function store()
    {
        // Validate first
        $validation = \Config\Services::validation();
        $validation->setRules([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'license_plate' => 'required|is_unique[cars.license_plate]',
            'daily_rate' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'uploaded[image]|max_size[image,4096]|is_image[image]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image upload
        $imageFile = $this->request->getFile('image');
        $newName = $imageFile->getRandomName();
        $imageFile->move('uploads/cars', $newName);

        $data = [
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'year' => $this->request->getPost('year'),
            'license_plate' => $this->request->getPost('license_plate'),
            'daily_rate' => $this->request->getPost('daily_rate'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status') ?? 'available',
            'category_id' => $this->request->getPost('category_id'),
            'image' => $newName
        ];

        if ($this->carModel->insert($data)) {
            // Get the ID of the newly inserted car
            $carId = $this->carModel->insertID();
            
            // Process and save discount data
            $this->saveDiscounts($carId);
            
            return redirect()->to('admin/cars')->with('success', 'Car added successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to add car');
        }
    }
    
    public function edit($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            return redirect()->to('/admin/cars')->with('error', 'Car not found');
        }
        
        $data = [
            'title' => 'Edit Car',
            'car' => $car,
            'categories' => $this->categoryModel->findAll()
        ];
        
        return view('admin/cars/edit', $data);
    }
    
    public function update($id = null)
    {
        // Validate first
        $validation = \Config\Services::validation();
        $validation->setRules([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|numeric',
            'license_plate' => "required|is_unique[cars.license_plate,id,$id]",
            'daily_rate' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Handle image upload if provided
        $imageFile = $this->request->getFile('image');
        $oldData = $this->carModel->find($id);

        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Delete old image
            if ($oldData && !empty($oldData['image']) && file_exists('uploads/cars/' . $oldData['image'])) {
                unlink('uploads/cars/' . $oldData['image']);
            }

            // Save new image
            $newName = $imageFile->getRandomName();
            $imageFile->move('uploads/cars', $newName);

            $data = [
                'brand' => $this->request->getPost('brand'),
                'model' => $this->request->getPost('model'),
                'year' => $this->request->getPost('year'),
                'license_plate' => $this->request->getPost('license_plate'),
                'daily_rate' => $this->request->getPost('daily_rate'),
                'description' => $this->request->getPost('description'),
                'status' => $this->request->getPost('status'),
                'category_id' => $this->request->getPost('category_id'),
                'image' => $newName
            ];
        } else {
            $data = [
                'brand' => $this->request->getPost('brand'),
                'model' => $this->request->getPost('model'),
                'year' => $this->request->getPost('year'),
                'license_plate' => $this->request->getPost('license_plate'),
                'daily_rate' => $this->request->getPost('daily_rate'),
                'description' => $this->request->getPost('description'),
                'status' => $this->request->getPost('status'),
                'category_id' => $this->request->getPost('category_id')
            ];
        }

        if ($this->carModel->update($id, $data)) {
            // Process and save discount data
            $this->saveDiscounts($id);
            
            return redirect()->to('admin/cars')->with('success', 'Car updated successfully');
        } else {
            return redirect()->back()->withInput()->with('error', 'Failed to update car');
        }
    }
    
    /**
     * Save discount data for a car
     * 
     * @param int $carId The car ID
     * @return void
     */
    private function saveDiscounts($carId)
    {
        // Delete existing discounts for this car
        $this->carDiscountModel->where('car_id', $carId)->delete();
        
        // Get discount data from form
        $discounts = $this->request->getPost('discounts');
        $toggles = $this->request->getPost('toggle_discount') ?? [];
        
        // Log the received discount data for debugging
        log_message('info', 'Discount data received: ' . json_encode($discounts));
        log_message('info', 'Toggle data received: ' . json_encode($toggles));
        
        // Save new discount days if any are selected
        if (is_array($discounts) && count($discounts) > 0) {
            foreach ($discounts as $day => $percentage) {
                // Only save if percentage is not empty and greater than 0
                if (!empty($percentage) && floatval($percentage) > 0) {
                    $this->carDiscountModel->insert([
                        'car_id' => $carId,
                        'discount_day' => $day,
                        'discount_percentage' => (float)$percentage,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    // Log successful insert
                    log_message('info', "Added discount for day {$day}: {$percentage}%");
                }
            }
        }
    }
    
    public function delete($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            return redirect()->to('/admin/cars')->with('error', 'Car not found');
        }
        
        // Delete image
        if ($car['image'] && file_exists(ROOTPATH . 'public/uploads/cars/' . $car['image'])) {
            unlink(ROOTPATH . 'public/uploads/cars/' . $car['image']);
        }
        
        $this->carModel->delete($id);
        
        return redirect()->to('/admin/cars')->with('success', 'Car deleted successfully');
    }

    public function detail($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            session()->setFlashdata('error', 'Mobil tidak ditemukan.');
            return redirect()->to('admin/cars');
        }
        
        $data = [
            'title' => 'Detail Mobil',
            'car' => $car
        ];
        
        return view('admin/cars/detail', $data);
    }
}

