<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ResetTokenModel;

class Auth extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url']);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        return view('auth/login', ['title' => 'Login']);
    }
    
    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $userModel = new UserModel();
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $user = $userModel->where('email', $email)->first();
        
        if (!$user || !password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau password salah. Silakan coba lagi.');
        }
        
        // Check if user is active
        if ($user['status'] == 'inactive') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Silakan hubungi admin.');
        }
        
        // Set session
        $this->setUserSession($user);
        
        // Redirect based on role
        if ($user['role'] == 'admin') {
            return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, Admin!');
        } else {
            return redirect()->to('/rentals')->with('success', 'Login berhasil!');
        }
    }
    
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        return view('auth/register', ['title' => 'Register']);
    }
    
    public function attemptRegister()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'phone' => 'required',
            'address' => 'required',
            'license_number' => 'required'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        
        $userModel = new UserModel();
        
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'license_number' => $this->request->getPost('license_number'),
            'role' => 'user',
            'status' => 'active',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        try {
            $userId = $userModel->insert($data, true);
            
            if ($userId) {
                log_message('info', 'New user registered with ID: {id}', ['id' => $userId]);
                
                // Auto-login new user
                $user = $userModel->find($userId);
                if ($user) {
                    $this->setUserSession($user);
                    return redirect()->to('/')->with('success', 'Pendaftaran berhasil! Anda telah otomatis login ke sistem.');
                }
                
                return redirect()->to('/login')->with('success', 'Pendaftaran berhasil. Silakan login dengan akun Anda.');
            } else {
                log_message('error', 'Failed to register new user: {errors}', ['errors' => json_encode($userModel->errors())]);
                return redirect()->back()->withInput()->with('error', 'Gagal mendaftar: ' . implode(', ', $userModel->errors()));
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception during user registration: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
    
    /**
     * Display the forgot password form
     */
    public function getForgotPassword()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        return view('auth/forgot_password', ['title' => 'Forgot Password']);
    }
    
    /**
     * Process the forgot password form
     */
    public function postForgotPassword()
    {
        $rules = [
            'email' => 'required|valid_email'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Silakan masukkan alamat email yang valid.');
        }
        
        $email = $this->request->getPost('email');
        
        // Koneksi langsung ke database untuk memastikan
        $db = db_connect();
        
        // Cek apakah email ada di database
        $query = $db->query("SELECT * FROM users WHERE email = ?", [$email]);
        $user = $query->getRowArray();
        
        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'Email tidak ditemukan. Silakan periksa kembali email Anda.');
        }
        
        // Buat token reset password
        try {
            // Pastikan tabel password_reset_tokens sudah ada
            if (!$db->tableExists('password_reset_tokens')) {
                $forge = \Config\Database::forge();
                $forge->addField([
                    'id' => [
                        'type' => 'INT',
                        'constraint' => 11,
                        'unsigned' => true,
                        'auto_increment' => true,
                    ],
                    'email' => [
                        'type' => 'VARCHAR',
                        'constraint' => 255,
                    ],
                    'token' => [
                        'type' => 'VARCHAR',
                        'constraint' => 64,
                    ],
                    'created_at' => [
                        'type' => 'DATETIME',
                    ],
                    'expires_at' => [
                        'type' => 'DATETIME',
                    ],
                ]);
                
                $forge->addKey('id', true);
                $forge->addKey('email');
                $forge->addKey('token');
                $forge->createTable('password_reset_tokens');
            }
            
            // Hapus token lama untuk email ini
            $db->query("DELETE FROM password_reset_tokens WHERE email = ?", [$email]);
            
            // Buat token baru
            $token = bin2hex(random_bytes(32));
            $now = date('Y-m-d H:i:s');
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 jam
            
            $db->query(
                "INSERT INTO password_reset_tokens (email, token, created_at, expires_at) VALUES (?, ?, ?, ?)", 
                [$email, $token, $now, $expires]
            );
            
            // Untuk pengujian, tampilkan link reset password
            $resetLink = site_url('reset-password/' . $token);
            return redirect()->back()->with('success', 'Link reset password telah dikirim. <br><a href="'.$resetLink.'" class="alert-link">Klik disini untuk reset password</a>');
            
            /* 
            // Kirim email - aktifkan nanti setelah konfigurasi email selesai
            $email = \Config\Services::email();
            
            $email->setFrom('noreply@carrent.com', 'CarRent Team');
            $email->setTo($user['email']);
            $email->setSubject('Reset Password');
            
            $message = "
                <h2>Reset Password</h2>
                <p>Halo {$user['name']},</p>
                <p>Anda telah meminta untuk mengatur ulang password. Silakan klik link di bawah ini untuk mengatur ulang password Anda:</p>
                <p><a href=\"{$resetLink}\">{$resetLink}</a></p>
                <p>Link ini akan kadaluarsa dalam 1 jam.</p>
                <p>Jika Anda tidak meminta reset password, abaikan email ini.</p>
                <p>Terima kasih,<br>Tim CarRent</p>
            ";
            
            $email->setMessage($message);
            $email->setMailType('html');
            
            if ($email->send()) {
                return redirect()->back()->with('success', 'Link reset password telah dikirim ke alamat email Anda.');
            } else {
                log_message('error', 'Gagal mengirim email reset password: ' . $email->printDebugger(['headers']));
                return redirect()->back()->with('error', 'Gagal mengirim email reset password. Silakan coba lagi nanti.');
            }
            */
        } catch (\Exception $e) {
            log_message('error', 'Exception saat reset password: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi nanti. Error: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the reset password form
     */
    public function getResetPassword($token = null)
    {
        if (!$token) {
            return redirect()->to('/forgot-password')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }
        
        $db = db_connect();
        $query = $db->query(
            "SELECT * FROM password_reset_tokens WHERE token = ? AND expires_at > ?", 
            [$token, date('Y-m-d H:i:s')]
        );
        $tokenData = $query->getRowArray();
        
        if (!$tokenData) {
            return redirect()->to('/forgot-password')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa. Silakan minta yang baru.');
        }
        
        return view('auth/reset_password', [
            'title' => 'Reset Password',
            'token' => $token
        ]);
    }
    
    /**
     * Process the reset password form
     */
    public function postResetPassword()
    {
        $rules = [
            'token' => 'required',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', implode('<br>', $this->validator->getErrors()));
        }
        
        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');
        
        try {
            $db = db_connect();
            
            // Verifikasi token
            $query = $db->query(
                "SELECT * FROM password_reset_tokens WHERE token = ? AND expires_at > ?", 
                [$token, date('Y-m-d H:i:s')]
            );
            $tokenData = $query->getRowArray();
            
            if (!$tokenData) {
                return redirect()->to('/forgot-password')->with('error', 'Link reset password tidak valid atau sudah kadaluarsa. Silakan minta yang baru.');
            }
            
            // Update password
            $email = $tokenData['email'];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $updated = $db->query(
                "UPDATE users SET password = ? WHERE email = ?", 
                [$hashedPassword, $email]
            );
            
            if ($db->affectedRows() > 0) {
                // Hapus token yang sudah digunakan
                $db->query("DELETE FROM password_reset_tokens WHERE token = ?", [$token]);
                
                return redirect()->to('/login')->with('success', 'Password Anda berhasil diperbarui. Silakan login dengan password baru Anda.');
            } else {
                return redirect()->back()->with('error', 'Gagal memperbarui password. Pengguna tidak ditemukan.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Exception saat reset password: {message}', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses permintaan Anda. Silakan coba lagi nanti.');
        }
    }
    
    private function setUserSession($user)
    {
        $data = [
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'isLoggedIn' => true
        ];
        
        session()->set($data);
        return true;
    }
}

