<?php

namespace App\Models;

use CodeIgniter\Model;

class FeedbackModel extends Model
{
    protected $table = 'feedback';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'feedback_type', 'description', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    protected $validationRules = [
        'user_id'       => 'required|numeric',
        'feedback_type' => 'required|numeric|in_list[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18]',
        'description'   => 'required|string|max_length[1000]'
    ];

    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required.',
            'numeric'  => 'User ID must be a number.'
        ],
        'feedback_type' => [
            'required' => 'Feedback type is required.',
            'in_list'  => 'Invalid feedback type.'
        ],
        'description' => [
            'required'   => 'Description is required.',
            'max_length' => 'Description must not exceed 1000 characters.'
        ]
    ];

    // Updated Feedback Type Mapping based on the new categories
    private $feedbackTypes = [
        // Positive Feedback – Appreciation or compliments
        1 => 'The admin is very responsive. Thank you!',
        2 => 'Common areas are always clean — good job to the cleaning staff.',
        3 => 'I love the quiet environment here.',
        4 => 'The new security lights outside are really helpful.',
        5 => 'Maintenance requests are always handled quickly.',
        6 => 'The new Wi-Fi router placement improved the signal.',
        
        // Neutral Feedback – Suggestions for improvement
        7 => 'Suggestion: Install a CCTV near the hallway.',
        8 => 'Please consider adding a drying area for laundry.',
        9 => 'It would be nice to have more cooking space',
        10 => 'More garbage bins on each floor would help a lot.',
        
        // Negative Feedback – Dissatisfaction not requiring urgent resolution
        11 => 'Sometimes the CR is not cleaned properly.',
        12 => 'Too much noise on weekends — no clear enforcement of rules.',
        13 => 'Wi-Fi goes down during peak hours, very frustrating.',
        14 => 'Laundry drying area gets overcrowded every day.'
    ];

    // Updated Level Mapping
    private $levelLabels = [
        1 => 'Positive Feedback',
        2 => 'Neutral Feedback',
        3 => 'Negative Feedback'
    ];

    // This method will add level and feedback type labels to the feedback items
    public function getFeedbackWithLabels($id = null)
    {
        $this->select('feedback.*, users.full_name as resident_name, rooms.room_number, rooms.bed_name');
        $this->join('users', 'users.id = feedback.user_id', 'left');
        $this->join('rooms', 'rooms.tenant_id = users.id', 'left');
        
        if ($id !== null) {
            $feedback = $this->find($id);
            
            if ($feedback) {
                // Add feedback type name
                $feedback['type'] = $this->feedbackTypes[$feedback['feedback_type']] ?? 'Unknown Feedback';
                
                // Add level based on the feedback_type range
                $levelType = $this->getLevelType($feedback['feedback_type']);
                $feedback['level'] = $levelType;
                $feedback['level_label'] = $this->levelLabels[$levelType] ?? 'Unknown Level';
                
                // Format room information
                if (!empty($feedback['room_number']) && !empty($feedback['bed_name'])) {
                    $feedback['room'] = $feedback['room_number'] . ' - ' . $feedback['bed_name'];
                } elseif (!empty($feedback['room_number'])) {
                    $feedback['room'] = $feedback['room_number'];
                } else {
                    $feedback['room'] = 'N/A';
                }
            }
            
            return $feedback;
        }
        
        $feedback = $this->findAll();

        foreach ($feedback as &$item) {
            // Add feedback type name (used as 'type' in the view)
            $item['type'] = $this->feedbackTypes[$item['feedback_type']] ?? 'Unknown Feedback';
            
            // Add level based on the feedback_type range
            $levelType = $this->getLevelType($item['feedback_type']);
            $item['level'] = $levelType;
            $item['level_label'] = $this->levelLabels[$levelType] ?? 'Unknown Level';
            
            // Format room information
            if (!empty($item['room_number']) && !empty($item['bed_name'])) {
                $item['room'] = $item['room_number'] . ' - ' . $item['bed_name'];
            } elseif (!empty($item['room_number'])) {
                $item['room'] = $item['room_number'];
            } else {
                $item['room'] = 'N/A';
            }
        }

        return $feedback;
    }

    // Updated helper function to get the level type based on the feedback name ranges
    private function getLevelType($feedbackName)
    {
        // Positive feedback (1-6)
        if ($feedbackName >= 1 && $feedbackName <= 6) {
            return 1; // Positive
        }
        // Neutral feedback (7-10)
        if ($feedbackName >= 7 && $feedbackName <= 10) {
            return 2; // Neutral
        }
        // Negative feedback (11-14)
        if ($feedbackName >= 11 && $feedbackName <= 14) {
            return 3; // Negative
        }
        return 1; // Default to positive if unknown
    }
    
    // Get feedback type text by ID
    public function getFeedbackTypeText($feedbackName)
    {
        return $this->feedbackTypes[$feedbackName] ?? 'Unknown Feedback';
    }
    
    // Get all available feedback types
    public function getFeedbackTypes()
    {
        return $this->feedbackTypes;
    }
    
    // Get level label by ID
    public function getLevelLabel($levelType)
    {
        return $this->levelLabels[$levelType] ?? 'Unknown Level';
    }
    
    // Get feedback by user ID with labels
    public function getFeedbackByUserId($userId)
    {
        $this->select('feedback.*, users.full_name as resident_name, rooms.room_number, rooms.bed_name');
        $this->join('users', 'users.id = feedback.user_id', 'left');
        $this->join('rooms', 'rooms.tenant_id = users.id', 'left');
        $feedback = $this->where('feedback.user_id', $userId)->findAll();
        
        foreach ($feedback as &$item) {
            // Add feedback type name (used as 'type' in the view)
            $item['type'] = $this->feedbackTypes[$item['feedback_type']] ?? 'Unknown Feedback';
            
            // Add level based on the feedback_type range
            $levelType = $this->getLevelType($item['feedback_type']);
            $item['level'] = $levelType;
            $item['level_label'] = $this->levelLabels[$levelType] ?? 'Unknown Level';
            
            // Format room information
            if (!empty($item['room_number']) && !empty($item['bed_name'])) {
                $item['room'] = $item['room_number'] . ' - ' . $item['bed_name'];
            } elseif (!empty($item['room_number'])) {
                $item['room'] = $item['room_number'];
            } else {
                $item['room'] = 'N/A';
            }
        }
        
        return $feedback;
    }
}