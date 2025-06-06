<?php
## ga kepake
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CarModel;
use App\Models\CategoryModel;
use App\Models\CarDiscountModel;

class CarsController extends BaseController
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
            'cars' => $this->carModel->select('cars.*, categories.name as category_name')
                        ->join('categories', 'categories.id = cars.category_id')
                        ->findAll(),
        ];
        
        return view('admin/cars/index', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Add New Car',
            'categories' => $this->categoryModel->findAll(),
        ];
        
        return view('admin/cars/form', $data);
    }
    
    public function store()
    {
        // Validate inputs
        $rules = [
            'brand' => 'required|min_length[2]',
            'model' => 'required|min_length[2]',
            'year' => 'required|numeric',
            'license_plate' => 'required|is_unique[cars.license_plate]',
            'daily_rate' => 'required|numeric',
            'category_id' => 'required|numeric',
            'image' => 'uploaded[image]|max_size[image,4096]|is_image[image]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        
        // Handle image upload
        $image = $this->request->getFile('image');
        $imageName = $image->getRandomName();
        $image->move(ROOTPATH . 'public/uploads/cars', $imageName);
        
        // Insert car data
        $carData = [
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'year' => $this->request->getPost('year'),
            'license_plate' => $this->request->getPost('license_plate'),
            'daily_rate' => $this->request->getPost('daily_rate'),
            'description' => $this->request->getPost('description'),
            'image' => $imageName,
            'status' => $this->request->getPost('status'),
            'category_id' => $this->request->getPost('category_id'),
        ];
        
        $this->carModel->insert($carData);
        $carId = $this->carModel->insertID();
        
        // Handle discount days
        $this->saveDiscountDays($carId);
        
        return redirect()->to('admin/cars')->with('success', 'Car added successfully');
    }
    
    public function edit($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            return redirect()->to('admin/cars')->with('error', 'Car not found');
        }
        
        $data = [
            'title' => 'Edit Car',
            'car' => $car,
            'categories' => $this->categoryModel->findAll(),
        ];
        
        return view('admin/cars/form', $data);
    }
    
    public function update($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            return redirect()->to('admin/cars')->with('error', 'Car not found');
        }
        
        // Validate inputs
        $rules = [
            'brand' => 'required|min_length[2]',
            'model' => 'required|min_length[2]',
            'year' => 'required|numeric',
            'license_plate' => "required|is_unique[cars.license_plate,id,$id]",
            'daily_rate' => 'required|numeric',
            'category_id' => 'required|numeric',
        ];
        
        // Only validate image if a new one is uploaded
        $image = $this->request->getFile('image');
        if ($image->isValid() && !$image->hasMoved()) {
            $rules['image'] = 'max_size[image,4096]|is_image[image]';
        }
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
        }
        
        // Car data to update
        $carData = [
            'brand' => $this->request->getPost('brand'),
            'model' => $this->request->getPost('model'),
            'year' => $this->request->getPost('year'),
            'license_plate' => $this->request->getPost('license_plate'),
            'daily_rate' => $this->request->getPost('daily_rate'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'category_id' => $this->request->getPost('category_id'),
        ];
        
        // Handle image update if needed
        if ($image->isValid() && !$image->hasMoved()) {
            // Delete old image
            if (!empty($car['image']) && file_exists(ROOTPATH . 'public/uploads/cars/' . $car['image'])) {
                unlink(ROOTPATH . 'public/uploads/cars/' . $car['image']);
            }
            
            // Save new image
            $imageName = $image->getRandomName();
            $image->move(ROOTPATH . 'public/uploads/cars', $imageName);
            $carData['image'] = $imageName;
        }
        
        $this->carModel->update($id, $carData);
        
        // Update discount days
        $this->saveDiscountDays($id);
        
        return redirect()->to('admin/cars')->with('success', 'Car updated successfully');
    }
    
    public function delete($id)
    {
        $car = $this->carModel->find($id);
        
        if (!$car) {
            return redirect()->to('admin/cars')->with('error', 'Car not found');
        }
        
        // Delete car image
        if (!empty($car['image']) && file_exists(ROOTPATH . 'public/uploads/cars/' . $car['image'])) {
            unlink(ROOTPATH . 'public/uploads/cars/' . $car['image']);
        }
        
        // Delete car discount days
        $this->carDiscountModel->where('car_id', $id)->delete();
        
        // Delete car
        $this->carModel->delete($id);
        
        return redirect()->to('admin/cars')->with('success', 'Car deleted successfully');
    }
    
    /**
     * Save discount days for a car
     *
     * @param int $carId The car ID
     * @return void
     */
    public function saveDiscountDays($carId)
    {
        // Delete existing discount days
        $this->carDiscountModel->where('car_id', $carId)->delete();
        
        // Get discount data from form
        $discounts = $this->request->getPost('discounts');
        log_message('error', json_encode($discounts));
        
        // Save new discount days if any are selected
        if (is_array($discounts) && count($discounts) > 0) {
            foreach ($discounts as $day => $percentage) {
                // Skip if percentage is empty or zero
                if (empty($percentage) || $percentage == 0) {
                    continue;
                }
                
                $this->carDiscountModel->insert([
                    'car_id' => $carId,
                    'discount_day' => $day,
                    'discount_percentage' => (float)$percentage, // Convert to float to handle decimal values
                ]);
            }
        }
    }
} 