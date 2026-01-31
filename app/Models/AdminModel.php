<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['username', 'email', 'password'];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    public function verifyLogin($email, $password)
    {
        $admin = $this->where('email', $email)->first();
        
        if ($admin) {
            // Direct password comparison (no hashing as requested)
            if ($password === $admin['password']) {
                return $admin;
            }
        }
        
        return null;
    }
}