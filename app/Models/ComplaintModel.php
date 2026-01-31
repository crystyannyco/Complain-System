<?php

namespace App\Models;

use CodeIgniter\Model;

class ComplaintModel extends Model
{
    protected $table = 'complaints';
    protected $primaryKey = 'complaint_id';
    protected $allowedFields = ['resident_id', 'type', 'description', 'status', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    protected $validationRules = [
        'resident_id'      => 'required|numeric',
        'type'   => 'required|numeric|in_list[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25]',
        'description'      => 'required|string|max_length[1000]',
    ];

    protected $validationMessages = [
        'resident_id' => [
            'required' => 'Resident ID is required.',
            'numeric'  => 'Resident ID must be a number.'
        ],
        'type' => [
            'required' => 'Complaint type is required.',
            'in_list'  => 'Invalid complaint type selected.'
        ],
        'description' => [
            'required'   => 'Description is required.',
            'max_length' => 'Description must not exceed 1000 characters.'
        ],
    ];

    private $complaintTypes = [
        // Level 1 - Low Priority
        1 => 'Trash bins left uncollected for a day',
        2 => 'Someone using personal belongings without asking',
        3 => 'Late response from admin or staff',
        4 => 'Wet floors in shared bathroom',
        5 => 'Room smells musty after cleaning',
        6 => 'Complaint about worn-out posters or signs',
        7 => 'Incomplete cleaning of common kitchen',
        8 => 'Light scolding from staff perceived as rude',

        // Level 2 - Medium Priority
        9 => 'Constant noise from neighbors or loud music at night',
        10 => 'Dirty common areas even after repeated reminders',
        11 => 'Frequent visitors violating house rules',
        12 => 'Roommate consistently disorganized or messy',
        13 => 'Disrespectful roommate behavior',
        14 => 'Unauthorized minor guest entering the premises',
        15 => 'Uncollected garbage attracting insects',

        // Level 3 - High Priority
        16 => 'Theft or missing personal belongings',
        17 => 'Physical or verbal harassment',
        18 => 'Unauthorized trespassing or loitering',
        19 => 'Threats or fights between tenants',
        20 => 'Roommate invasion of privacy',
        21 => 'Reports of alcohol, drugs, or weapon possession',
        22 => 'Bullying or discrimination (race, gender, religion, etc.)',
        23 => 'Resident violating curfew with aggressive behavior',
        24 => 'Fire or emergency exit blocked by belongings',
        25 => 'Serious privacy invasion (recording someone, breaking into room)'
    ];

    private $priorityLabels = [
        1 => 'Low (Level 1) - Minor Issues',
        2 => 'Medium (Level 2) - Moderate Issues',
        3 => 'High (Level 3) - Urgent/Serious Issues'
    ];

    public function getComplaintsWithLabels($id = null)
    {
        $this->select('complaints.*, users.full_name as resident_name, rooms.room_number, rooms.bed_name');
        $this->join('users', 'users.id = complaints.resident_id', 'left');
        $this->join('rooms', 'rooms.tenant_id = users.id', 'left');
        
        if ($id !== null) {
            // Your existing code for single complaint
            $complaint = $this->find($id);
            // Process and return the single complaint
            // ...
            return $complaint;
        }
        
        // Process multiple complaints
        $complaints = $this->findAll();
        
        foreach ($complaints as &$complaint) {
            $typeId = $complaint['type'];
            // Store the numerical type ID
            $complaint['type_id'] = $typeId;
            $complaint['type'] = $this->complaintTypes[$typeId] ?? 'Unknown Complaint';
            
            $priorityLevel = $this->getPriorityLevel($typeId);
            $complaint['priority'] = $priorityLevel;
            $complaint['priority_label'] = $this->priorityLabels[$priorityLevel] ?? 'Unknown Priority';
            
            $statusLabels = [
                0 => 'Pending',
                1 => 'In Progress',
                2 => 'Resolved',
                3 => 'Rejected'
            ];
            
            // Store numeric status before overwriting
            $complaint['status'] = $complaint['status'];
            $complaint['status'] = $statusLabels[$complaint['status']] ?? 'Pending';
            
            // Format room information
            if (!empty($complaint['room_number']) && !empty($complaint['bed_name'])) {
                $complaint['room'] = $complaint['room_number'] . ' - ' . $complaint['bed_name'];
            } elseif (!empty($complaint['room_number'])) {
                $complaint['room'] = $complaint['room_number'];
            } else {
                $complaint['room'] = 'N/A';
            }
        }
        
        return $complaints;
    }

    private function getPriorityLevel($complaintTypeId)
    {
        if ($complaintTypeId >= 16) {
            return 3; // High
        } elseif ($complaintTypeId >= 9) {
            return 2; // Medium
        } else {
            return 1; // Low
        }
    }

    public function getComplaintTypeText($complaintTypeId)
    {
        return $this->complaintTypes[$complaintTypeId] ?? 'Unknown Complaint';
    }

    public function getComplaintTypes()
    {
        return $this->complaintTypes;
    }

    public function getComplaintsWithLabelsByUser($userId)
    {
        // Get only complaints for this user
        $this->select('complaints.*, users.full_name as resident_name, rooms.room_number, rooms.bed_name');
        $this->join('users', 'users.id = complaints.resident_id', 'left');
        $this->join('rooms', 'rooms.tenant_id = users.id', 'left');
        $complaints = $this->where('complaints.resident_id', $userId)->findAll();
    
        foreach ($complaints as &$complaint) {
            $typeId = $complaint['type'];
            // Store the numerical type ID before overwriting it with the text description
            $complaint['type_id'] = $typeId;
            $complaint['type'] = $this->complaintTypes[$typeId] ?? 'Unknown Complaint';
    
            $priorityLevel = $this->getPriorityLevel($typeId);
            $complaint['priority'] = $priorityLevel;
            $complaint['priority_label'] = $this->priorityLabels[$priorityLevel] ?? 'Unknown Priority';
    
            $statusLabels = [
                0 => 'Pending',
                1 => 'In Progress',
                2 => 'Resolved',
                3 => 'Rejected'
            ];
            
            // Store numeric status before overwriting
            $complaint['status'] = $complaint['status'];
            $complaint['status'] = $statusLabels[$complaint['status']] ?? 'Pending';
            
            // Format room information as "Room Number - Bed Name" if both exist
            if (!empty($complaint['room_number']) && !empty($complaint['bed_name'])) {
                $complaint['room'] = $complaint['room_number'] . ' - ' . $complaint['bed_name'];
            } elseif (!empty($complaint['room_number'])) {
                $complaint['room'] = $complaint['room_number'];
            } else {
                $complaint['room'] = 'N/A';
            }
        }
    
        return $complaints;
    }
}