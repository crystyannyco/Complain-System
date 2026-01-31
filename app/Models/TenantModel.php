<?php
namespace App\Models;
use CodeIgniter\Model;
class TenantModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'full_name', 'username', 'email', 'phone', 'address',
        'birthdate', 'password', 'status'
    ];    

    protected $validationRules = [
        'full_name'         => 'required|min_length[3]',
        'username'          => 'required|min_length[3]|is_unique[users.username]',
        'email'             => 'required|valid_email|is_unique[users.email]',
        'phone'             => 'required|min_length[10]',
        'password'          => 'required|min_length[6]',
        'birthdate'         =>'required',
    ];

    protected $validationMessages = [
        'full_name' => [
            'required' => 'Full Name is required.',
            'min_length' => 'Full Name must be at least 3 characters long.'
        ],
        'username' => [
            'required' => 'Username is required.',
            'min_length' => 'Username must be at least 3 characters.',
            'is_unique' => 'This username is already taken.'
        ],
        'email' => [
            'required' => 'Email is required.',
            'valid_email' => 'Please provide a valid email address.',
            'is_unique' => 'This email is already registered.'
        ],
        'phone' => [
            'required' => 'Phone number is required.',
            'min_length' => 'Phone number must be at least 10 digits.'
        ],
        'password' => [
            'required' => 'Password is required.',
            'min_length' => 'Password must be at least 6 characters long.'
        ],
        'birthdate' => [
           'required' => 'Birthdate is required.'
        ],
        
    ];    

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    public function verifyLogin($email, $password)
    {
        $user = $this->where('email', $email)->first();
        
        if ($user) {
            // Verify the password against the stored hash
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return null;
    }
    
    public function getTenantsWithStatusLabel()
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*');
        $tenants = $builder->get()->getResultArray();
        foreach ($tenants as &$tenant) {
            // Use string comparison since status is stored as string
            $tenant['status_label'] = $tenant['status'] === '1' ? 'Active' : 'Inactive';
        }
        return $tenants;
    }

    public function getActiveTenants()
    {
        // Use string '1' to match how it's stored in the database
        return $this->where('status', '1')->findAll();
    }

    public function getTenantWithRoomInfo($id)
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*, rooms.room_id, rooms.room_number, rooms.bed_name, rooms.move_in as move_in, rooms.move_out as move_out');
        $builder->join('rooms', 'rooms.tenant_id = users.id', 'left');
        $builder->where('users.id', $id);
        $result = $builder->get()->getRowArray();
        
        if ($result) {
            // Use string comparison since status is stored as string
            $result['status_label'] = $result['status'] === '1' ? 'Active' : 'Inactive';
        }
        
        return $result;
    }

    public function getTenantsWithRoomInfo()
    {
        $builder = $this->db->table($this->table);
        $builder->select('users.*, rooms.room_id, rooms.room_number, rooms.bed_name, rooms.move_in as move_in, rooms.move_out as move_out');
        $builder->join('rooms', 'rooms.tenant_id = users.id', 'left');
        $tenants = $builder->get()->getResultArray();
        
        foreach ($tenants as &$tenant) {
            // Use string comparison since status is stored as string
            $tenant['status_label'] = $tenant['status'] === '1' ? 'Active' : 'Inactive';
        }
        
        return $tenants;
    }

    public function updateTenantProfile($userId, $request)
    {
        $this->skipValidation(true);

        // Create basic tenant data array
        $tenantData = [
            'full_name' => $request->getPost('full_name'),
            'username'  => $request->getPost('username'),
            'email'     => $request->getPost('email'),
            'phone'     => $request->getPost('phone'),
            'address'   => $request->getPost('address'),
            'birthdate' => $request->getPost('birthdate'),
        ];
        
        // IMPORTANT: Fix the status update - get status value properly
        // Don't pass a filter parameter to getPost
        $status = $request->getPost('status');
        if ($status !== null) {
            $tenantData['status'] = (string)$status;
        }

        // Handle password update if provided
        $newPassword = $request->getPost('password');
        $passwordConfirm = $request->getPost('password_confirm');

        if (!empty($newPassword)) {
            if ($newPassword !== $passwordConfirm) {
                return false;
            }
            
            $tenantData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }
        
        // Perform the update
        return $this->update($userId, $tenantData);
    }
    

}