<?php
// Update the RoomModel to include new fields
namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $table = 'rooms';
    protected $primaryKey = 'room_id';
    protected $allowedFields = [
        'room_number', 
        'capacity', 
        'bed_name', 
        'status', 
        'tenant_id',      // New field for the occupying user
        'move_in', // New field for move-in date
        'move_out', // New field for move-out date
        'created_at', 
        'updated_at'
    ];
    
    // Set timestamp fields but handle them manually
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    // Updated validation rules
    protected $validationRules = [
        'room_number' => 'required|numeric',
        'capacity' => 'required|numeric|greater_than[0]',
        'bed_name' => 'required|alpha_numeric_punct|max_length[10]',
        'status' => 'required|in_list[0,1,2,3]',
    ];
    
    protected $validationMessages = [
        'room_number' => [
            'required' => 'Room number is required',
            'numeric' => 'Room number must be a number'
        ],
        'capacity' => [
            'required' => 'Capacity is required',
            'numeric' => 'Capacity must be a number',
            'greater_than' => 'Capacity must be greater than 0'
        ],
        'bed_name' => [
            'required' => 'Bed name is required',
            'alpha_numeric_punct' => 'Bed name may only contain alphanumeric characters, spaces, and symbols',
            'max_length' => 'Bed name cannot exceed 10 characters'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be a valid option'
        ],
    ];

    protected $skipValidation = false;
    
    public function getAllRooms()
    {
        return $this->findAll();
    }
    
    public function getRoomById($id)
    {
        return $this->find($id);
    }
    
    // Get rooms with status translation and user info
    public function getRoomsWithStatusLabel()
    {
        $rooms = $this->findAll();
        $statusLabels = [
            0 => 'Available',
            1 => 'Occupied',
            2 => 'Reserved',
            3 => 'Maintenance'
        ];
        
        $tenantModel = new \App\Models\TenantModel();

        foreach ($rooms as &$room) {
            // Add status label
            $room['status_label'] = $statusLabels[$room['status']] ?? 'Unknown';

            // Add tenant name
            if (!empty($room['tenant_id'])) {
                $tenant = $tenantModel->find($room['tenant_id']);
                $room['tenant_name'] = $tenant ? $tenant['full_name'] : 'Unknown Tenant';
            } else {
                $room['tenant_name'] = null;
            }
        }

        return $rooms;
    }

    
    // Use beforeInsert method to automatically format dates correctly
    protected function beforeInsert(array $data)
    {
        $data['data']['created_at'] = date('Y-m-d H:i:s');
        $data['data']['updated_at'] = date('Y-m-d');
        
        return $data;
    }

    // Use beforeUpdate method to automatically update the updated_at timestamp
    protected function beforeUpdate(array $data)
    {
        $data['data']['updated_at'] = date('Y-m-d');
        
        return $data;
    }

    
}
