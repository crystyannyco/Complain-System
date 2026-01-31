<?php

namespace App\Models;

use CodeIgniter\Model;

class MaintenanceModel extends Model
{
    protected $table = 'maintenance';
    protected $primaryKey = 'maintenance_id';
    protected $allowedFields = ['resident_id', 'room_id', 'issue_type', 'description', 'status', 'priority', 'reported_date', 'resolved_date'];

    protected $useTimestamps = true;
    protected $createdField = 'reported_date';
    protected $updatedField = '';

    protected $validationRules = [
        'resident_id'  => 'required|numeric',
        'room_id'      => 'required|numeric',
        'issue_type'   => 'required|in_list[1,2,3,4,5,6,7,8,9,10]',
        'description'  => 'required|string|max_length[1000]',
        'priority'     => 'required|in_list[1,2,3]',
        'status'       => 'required|in_list[0,1,2,3]',
    ];

    protected $validationMessages = [
        'resident_id' => [
            'required' => 'Resident ID is required.',
            'numeric'  => 'Resident ID must be a number.'
        ],
        'room_id' => [
            'required' => 'Room ID is required.',
            'numeric'  => 'Room ID must be a number.'
        ],
        'issue_type' => [
            'required' => 'Maintenance issue type is required.',
            'in_list'  => 'Invalid maintenance issue type selected.'
        ],
        'description' => [
            'required'   => 'Description is required.',
            'max_length' => 'Description must not exceed 1000 characters.'
        ],
        'priority' => [
            'required' => 'Priority is required.',
            'in_list'  => 'Invalid priority level selected.'
        ],
        'status' => [
            'required' => 'Status is required.',
            'in_list'  => 'Invalid status selected.'
        ]
    ];

    private $issueTypes = [
        1 => 'Plumbing (leaks, clogs, water pressure)',
        2 => 'Electrical (outages, outlets, lights)',
        3 => 'Structural (walls, ceiling, floor)',
        4 => 'Locks/Keys/Security',
        5 => 'Pest control',
        6 => 'Internet/Network issues',
        7 => 'Furniture repair/replacement',
        8 => 'Other maintenance issues'
    ];

    private $priorityLabels = [
        1 => 'Low - Can be scheduled',
        2 => 'Medium - Needs attention soon',
        3 => 'High - Urgent attention required'
    ];

    private $statusLabels = [
        0 => 'Pending',
        1 => 'In Progress',
        2 => 'Completed',
        3 => 'Denied'
    ];

    public function getIssueTypes()
    {
        return $this->issueTypes;
    }

    public function getPriorityLabels()
    {
        return $this->priorityLabels;
    }

    public function getStatusLabels()
    {
        return $this->statusLabels;
    }

    public function getMaintenanceWithDetails()
    {
        $maintenance = $this->findAll();

        foreach ($maintenance as &$item) {
            // Add issue type text
            $item['issue_type_text'] = $this->issueTypes[$item['issue_type']] ?? 'Unknown Issue';
            
            // Add priority text
            $item['priority_text'] = $this->priorityLabels[$item['priority']] ?? 'Unknown Priority';
            
            // Add status text
            $statusId = $item['status'];
            $item['status_text'] = $this->statusLabels[$statusId] ?? 'Unknown Status';
            $item['status_id'] = $statusId; // Store numeric status
        }

        return $maintenance;
    }

    public function getMaintenanceWithRoom()
    {
        $builder = $this->db->table('maintenance m');
        $builder->select('m.*, t.full_name as resident_name, r.room_number');
        $builder->join('users t', 't.id = m.resident_id', 'left');
        $builder->join('rooms r', 'r.room_id = m.room_id', 'left');
        
        $result = $builder->get()->getResultArray();
        
        foreach ($result as &$item) {
            // Add issue type text
            $item['issue_type_text'] = $this->issueTypes[$item['issue_type']] ?? 'Unknown Issue';
            
            // Add priority text
            $item['priority_text'] = $this->priorityLabels[$item['priority']] ?? 'Unknown Priority';
            
            // Add status text
            $statusId = $item['status'];
            $item['status_text'] = $this->statusLabels[$statusId] ?? 'Unknown Status';
            $item['status_id'] = $statusId; // Store numeric status
        }
        
        return $result;
    }

    public function getMaintenanceByUserId($userId)
    {
        $builder = $this->db->table('maintenance m');
        $builder->select('m.*, t.full_name as resident_name, r.room_number, r.bed_name');
        $builder->join('users t', 't.id = m.resident_id', 'left');
        $builder->join('rooms r', 'r.room_id = m.room_id', 'left');
        $builder->where('m.resident_id', $userId);
        
        $result = $builder->get()->getResultArray();
        
        foreach ($result as &$item) {
            // Add issue type text
            $item['issue_type_text'] = $this->issueTypes[$item['issue_type']] ?? 'Unknown Issue';
            
            // Add priority text
            $item['priority_text'] = $this->priorityLabels[$item['priority']] ?? 'Unknown Priority';
            
            // Add status text
            $statusId = $item['status'];
            $item['status_text'] = $this->statusLabels[$statusId] ?? 'Unknown Status';
            $item['status_id'] = $statusId; // Store numeric status
        }
        
        return $result;
    }
}