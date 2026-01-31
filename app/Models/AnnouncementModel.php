<?php
    namespace App\Models;

    use CodeIgniter\Model;
    use CodeIgniter\Validation\Validation;
    
    class AnnouncementModel extends Model
    {
        protected $table = 'announcements';
        protected $primaryKey = 'id';
        protected $allowedFields = ['title', 'content', 'created_at'];
    
        // Validation rules
        protected $validationRules = [
            'title'   => 'required|min_length[5]|max_length[255]',
            'content' => 'required|min_length[10]',
        ];
    
        // Custom error messages
        protected $validationMessages = [
            'title' => [
                'required'   => 'The title field is required.',
                'min_length' => 'The title must be at least 5 characters long.',
                'max_length' => 'The title cannot exceed 255 characters.',
            ],
            'content' => [
                'required'   => 'The content field is required.',
                'min_length' => 'The content must be at least 10 characters long.',
            ],
        ];
    
        // Validate data before saving
        public function validateAnnouncement($data)
        {
            if (!$this->validate($data)) {
                return $this->errors();
            }
            return true;
        }
    }
    