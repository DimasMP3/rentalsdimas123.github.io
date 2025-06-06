<?php

namespace App\Models;

use CodeIgniter\Model;

class ResetTokenModel extends Model
{
    protected $table = 'password_reset_tokens';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = ['email', 'token', 'created_at', 'expires_at'];
    protected $useTimestamps = false;
    
    /**
     * Create a new password reset token for the user
     *
     * @param string $email User's email
     * @return string Generated token
     */
    public function createToken($email)
    {
        // First delete any existing tokens for this email
        $this->where('email', $email)->delete();
        
        // Generate a random token
        $token = bin2hex(random_bytes(32));
        
        // Set expiration time (1 hour from now)
        $expires = date('Y-m-d H:i:s', time() + 3600);
        
        $data = [
            'email' => $email,
            'token' => $token,
            'created_at' => date('Y-m-d H:i:s'),
            'expires_at' => $expires
        ];
        
        $this->insert($data);
        
        return $token;
    }
    
    /**
     * Verify if a token is valid and not expired
     *
     * @param string $token Reset token
     * @return array|bool User's email if valid, false otherwise
     */
    public function verifyToken($token)
    {
        $resetToken = $this->where('token', $token)
                          ->where('expires_at >', date('Y-m-d H:i:s'))
                          ->first();
        
        if ($resetToken) {
            return $resetToken['email'];
        }
        
        return false;
    }
    
    /**
     * Delete a token after it's been used
     *
     * @param string $token Reset token
     * @return void
     */
    public function deleteToken($token)
    {
        $this->where('token', $token)->delete();
    }
    
    /**
     * Delete expired tokens
     *
     * @return void
     */
    public function purgeExpiredTokens()
    {
        $this->where('expires_at <', date('Y-m-d H:i:s'))->delete();
    }
} 