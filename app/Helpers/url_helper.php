<?php

/**
 * URL Helper Functions
 * 
 * Fungsi-fungsi pembantu tambahan untuk URL
 */

if (!function_exists('is_url_active')) {
    /**
     * Memeriksa apakah URL saat ini berisi segmen tertentu
     * untuk menentukan apakah menu aktif
     * 
     * @param string $segment Segmen URL yang ingin dicek
     * @return bool
     */
    function is_url_active($segment)
    {
        $currentURL = current_url();
        if (empty($currentURL)) {
            return false;
        }
        
        return strpos($currentURL, $segment) !== false;
    }
}

if (!function_exists('is_home')) {
    /**
     * Memeriksa apakah URL saat ini adalah halaman beranda
     * 
     * @return bool
     */
    function is_home()
    {
        $currentURL = current_url();
        if (empty($currentURL)) {
            return false;
        }
        
        return $currentURL == base_url() || 
               $currentURL == base_url('index.php') || 
               $currentURL == base_url('home');
    }
}

if (!function_exists('get_active_class')) {
    /**
     * Mendapatkan kelas 'active' untuk menu jika URL saat ini mengandung segmen tertentu
     * 
     * @param string $segment Segmen URL yang akan diperiksa
     * @param string $class Kelas yang akan ditambahkan jika aktif (default: 'active')
     * @return string
     */
    function get_active_class($segment, $class = 'active')
    {
        return is_url_active($segment) ? $class : '';
    }
} 