<?php

/**
 * Session Helper Functions
 * 
 * Fungsi-fungsi pembantu untuk mengelola sesi dengan lebih aman
 */

if (!function_exists('is_logged_in')) {
    /**
     * Memeriksa apakah pengguna sudah login
     * 
     * @return bool
     */
    function is_logged_in()
    {
        return session()->has('isLoggedIn') && session()->get('isLoggedIn') === true;
    }
}

if (!function_exists('is_admin')) {
    /**
     * Memeriksa apakah pengguna yang login adalah admin
     * 
     * @return bool
     */
    function is_admin()
    {
        return is_logged_in() && session()->has('role') && session()->get('role') === 'admin';
    }
}

if (!function_exists('get_user_name')) {
    /**
     * Mengambil nama pengguna yang sedang login
     * 
     * @param string $default Nilai default jika nama tidak ditemukan
     * @return string
     */
    function get_user_name($default = 'User')
    {
        return is_logged_in() && session()->has('name') ? session()->get('name') : $default;
    }
}

if (!function_exists('get_user_initial')) {
    /**
     * Mengambil inisial nama pengguna (huruf pertama)
     * 
     * @param string $default Nilai default jika nama tidak ditemukan
     * @return string
     */
    function get_user_initial($default = 'U')
    {
        $name = get_user_name($default);
        return substr($name, 0, 1);
    }
} 