<?php

namespace App\Controllers;

class Gallery extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Gallery - CarRent'
        ];
        
        return view('pages/gallery', $data);
    }
    
    public function getGallery()
    {
        // This method is being called from the error, so we'll implement it
        // It simply redirects to the index method for now
        return $this->index();
    }
} 