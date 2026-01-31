<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\TenantModel;
use App\Models\RoomModel;
use App\Models\PositionModel;
use App\Models\ComplaintModel;
use App\Models\FeedbackModel;
use App\Models\AnnouncementModel;
use App\Models\maintenanceModel;

class UserController extends BaseController
{
    public function home()
    {
        $announcementModel = new AnnouncementModel();
        $announcements = $announcementModel->orderBy('created_at', 'DESC')->findAll(3);

        $data = [
            'announcements' => $announcements,
        ];

        return 
            view('template/user/header').
            view('User/dashboard', $data).
            view('template/user/footer');
    }
    

    public function tenants()
    {
        // Get the current logged in user's ID from session
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to view this page.');
        }
        
        $TenantModel = new TenantModel();
        
        // Get only the logged-in tenant's information
        $tenant = $TenantModel->getTenantWithRoomInfo($userId);
        
        $data = [
            'page_title' => 'My Profile',
            'tenant' => $tenant,
            'validation' => \Config\Services::validation(),
        ];
    
        return 
            view('template/user/header').
            view('User/tenants', $data).
            view('template/user/footer');
    }

    public function editTenantForm()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to edit your profile.');
        }
        
        $TenantModel = new TenantModel();
        $tenant = $TenantModel->getTenantWithRoomInfo($userId);
        
        if (!$tenant) {
            session()->setFlashdata('error', 'Profile not found.');
            return redirect()->to(base_url('User/dashboard'));
        }

        $data = [
            'page_title' => 'Edit Profile',
            'tenant' => $tenant,
            'validation' => \Config\Services::validation(),
        ];

        return 
            view('template/user/header') .
            view('User/edit_tenant', $data) .
            view('template/user/footer');
    }

    public function update()
    {
        $userId = session()->get('id');

        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to update your profile.');
        }

        $TenantModel = new TenantModel();
        $tenant = $TenantModel->find($userId);

        if (!$tenant) {
            session()->setFlashdata('error', 'Profile not found.');
            return redirect()->to(base_url('User/dashboard'));
        }

        // Custom validation
        $rules = [
            'full_name' => 'required|min_length[3]',
            'username'  => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'email'     => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'phone'     => 'required|min_length[10]',
        ];

        if (!$this->validate($rules)) {
            session()->setFlashdata('error', 'Please check your input.');
            return redirect()->to(base_url('User/tenants/edit'))
                ->withInput()
                ->with('validation', $this->validator);
        }

        // Call the new model method
        $updateResult = $TenantModel->updateTenantProfile($userId, $this->request);

        if ($updateResult) {
            session()->setFlashdata('success', 'Profile updated successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to update profile.');
        }

        return redirect()->to(base_url('User/tenants'));
    }
    
    public function complaints()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to view this page.');
        }
        
        $complaintModel = new ComplaintModel();
        // Get only the logged-in user's complaints
        $complaints = $complaintModel->getComplaintsWithLabelsByUser($userId);
        
        // Transform the data to match what the view expects
        foreach ($complaints as &$complaint) {
            // Ensure each complaint has the ID field that the view expects
            $complaint['id'] = $complaint['type'];
        }
        
        $data = [
            'page_title' => 'My Complaints',
            'complaints' => $complaints,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/user/header') .
            view('User/complaints', $data) .
            view('template/user/footer');
    }

    
    public function addComplaintForm(): string
    {
        $userId = session()->get('id');

        $complaintModel = new ComplaintModel();
        
        $data = [
            'user_id' => 'userID',
            'page_title' => 'Add Complaint',
            'validation' => \Config\Services::validation(),
            'complaintTypes' => $complaintModel->getComplaintTypes(), 
        ];
        
        return 
            view('template/user/header') .
            view('User/add_complaint', $data) .
            view('template/user/footer');
    }
    
    public function addComplaint()
    {
        $complaintModel = new ComplaintModel();
        
        // Get current user's ID from session
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to submit a complaint.');
        }
        
        // Get the submitted data
        $data = [
            'resident_id' => $userId, // Use the logged-in user's ID instead of form input
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'status' => 0, // 0 = Pending in numeric format as required by model
        ];
        
        if (!$complaintModel->insert($data)) {
            return redirect()->to(base_url('User/complaints/add'))
                ->withInput()
                ->with('errors', $complaintModel->errors());
        }
        
        session()->setFlashdata('success', 'Complaint submitted successfully.');
        return redirect()->to(base_url('User/complaints'));
    }

    public function editComplaintForm($id): string
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to edit a complaint.');
        }
        
        $complaintModel = new ComplaintModel();
        $complaint = $complaintModel->find($id);
        
        if (!$complaint) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('/User/complaints'));
        }
        
        // Check if this complaint belongs to the logged-in user
        if ($complaint['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only edit your own complaints.');
            return redirect()->to(base_url('/User/complaints'));
        }
        
        $data = [
            'page_title' => 'Edit Complaint',
            'complaint' => $complaint,
            'complaintTypes' => $complaintModel->getComplaintTypes(),
            'validation' => \Config\Services::validation(),
            'complaintTypeText' => $complaintModel->getComplaintTypeText($complaint['type'])
        ];
        
        return 
            view('template/user/header') .
            view('User/edit_complaint', $data) .
            view('template/user/footer');
    }

    // Update updateComplaint() to check if complaint belongs to user
    public function updateComplaint($id)
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to update a complaint.');
        }
        
        $complaintModel = new ComplaintModel();
        $complaint = $complaintModel->find($id);
        
        if (!$complaint) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('User/complaints'));
        }
        
        // Check if this complaint belongs to the logged-in user
        if ($complaint['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only update your own complaints.');
            return redirect()->to(base_url('User/complaints'));
        }
        
        $data = [
            'resident_id' => $userId, // Ensure it's still the user's ID
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
        ];
        
        if (!$complaintModel->update($id, $data)) {
            return redirect()->to(base_url("User/complaints/edit/$id"))
                ->withInput()
                ->with('errors', $complaintModel->errors());
        }
        
        session()->setFlashdata('success', 'Complaint updated successfully.');
        return redirect()->to(base_url('User/complaints'));
    }

    // Update deleteComplaint() to check if complaint belongs to user
    public function deleteComplaint($id)
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to delete a complaint.');
        }
        
        $complaintModel = new ComplaintModel();
        $complaint = $complaintModel->find($id);
        
        if (!$complaint) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('User/complaints'));
        }
        
        // Check if this complaint belongs to the logged-in user
        if ($complaint['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only delete your own complaints.');
            return redirect()->to(base_url('User/complaints'));
        }
        
        $complaintModel->delete($id);
        
        session()->setFlashdata('success', 'Complaint deleted successfully.');
        return redirect()->to(base_url('User/complaints'));
    }


    public function feedbacks()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to view this page.');
        }
        
        $feedbackModel = new FeedbackModel();
        // Get only the logged-in user's feedback
        $feedback = $feedbackModel->getFeedbackByUserId($userId);
        
        $data = [
            'page_title' => 'My Feedback',
            'feedback' => $feedback,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/user/header') .
            view('User/feedbacks', $data) .
            view('template/user/footer');
    }

    public function addFeedbackForm(): string
    {
        $feedbackModel = new FeedbackModel();
        
        // Get the currently logged-in user's ID
        $userId = session()->get('id'); // Adjust this based on your session variable name
        
        $data = [
            'page_title' => 'Add Feedback',
            'validation' => \Config\Services::validation(),
            'feedbackTypes' => $feedbackModel->getFeedbackTypes(),
            'user_id' => $userId // Pass the user_id to the view
        ];
        
        return 
            view('template/user/header') .
            view('User/add_feedback', $data) .
            view('template/user/footer');
    }

    public function addFeedback()
    {
        $feedbackModel = new FeedbackModel();
        
        // Get the currently logged-in user's ID
        $userId = session()->get('id'); // Adjust this based on your session variable name
        
        // Get the submitted data
        $data = [
            'user_id' => $userId, // Changed 'id' to 'user_id' to match the model's expected field
            'feedback_type' => $this->request->getPost('feedback_type'),
            'description' => $this->request->getPost('description'),
        ];
        
        if (!$feedbackModel->insert($data)) {
            return redirect()->to(base_url('User/feedbacks/add'))
                ->withInput()
                ->with('errors', $feedbackModel->errors());
        }
        
        session()->setFlashdata('success', 'Feedback submitted successfully.');
        return redirect()->to(base_url('User/feedbacks'));
    }

    public function editFeedbackForm($id)
    {
        $feedbackModel = new FeedbackModel();
        $userId = session()->get('id'); // Get current user ID
        
        // Find the feedback and check if it belongs to the current user
        $feedback = $feedbackModel->find($id);
        if (!$feedback || $feedback['user_id'] != $userId) {
            session()->setFlashdata('error', 'Feedback not found or you do not have permission to edit it.');
            return redirect()->to(base_url('User/feedbacks'));
        }
        
        $data = [
            'page_title' => 'Edit Feedback',
            'feedback' => $feedback,
            'feedbackTypes' => $feedbackModel->getFeedbackTypes(),
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/user/header') .
            view('User/edit_feedback', $data) .
            view('template/user/footer');
    }

    public function updateFeedback($id)
    {
        $feedbackModel = new FeedbackModel();
        $userId = session()->get('id'); // Get current user ID
        
        // Find the feedback and check if it belongs to the current user
        $feedback = $feedbackModel->find($id);
        if (!$feedback || $feedback['user_id'] != $userId) {
            session()->setFlashdata('error', 'Feedback not found or you do not have permission to edit it.');
            return redirect()->to(base_url('User/feedbacks'));
        }
        
        $data = [
            'feedback_type' => $this->request->getPost('feedback_type'),
            'description' => $this->request->getPost('description'),
            // Don't update user_id to ensure it stays the same
        ];
        
        if (!$feedbackModel->update($id, $data)) {
            return redirect()->to(base_url("User/feedbacks/edit/$id"))
                    ->withInput()
                    ->with('errors', $feedbackModel->errors());
        }
        
        session()->setFlashdata('success', 'Feedback updated successfully.');
        return redirect()->to(base_url('User/feedbacks'));
    }

    public function deleteFeedback($id)
    {
        $feedbackModel = new FeedbackModel();
        $userId = session()->get('id'); // Get current user ID
    
        
        $feedbackModel->delete($id);
        
        session()->setFlashdata('success', 'Feedback deleted successfully.');
        return redirect()->to(base_url('User/feedbacks'));
    }
    
    public function maintenance()
    {
        $userId = session()->get('id');
        
        if (!$userId) {
            return redirect()->to(base_url('login'))->with('error', 'You must be logged in to view this page.');
        }
        
        $maintenanceModel = new MaintenanceModel();
        // Get only the current user's maintenance requests
        $maintenance = $maintenanceModel->getMaintenanceByUserId($userId);
        
        $data = [
            'page_title' => 'Maintenance',
            'maintenance' => $maintenance,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/user/header') .
            view('User/maintenance', $data) .
            view('template/user/footer');
    }
    
    public function addMaintenanceForm(): string
    {
        $maintenanceModel = new MaintenanceModel();
        $tenantModel = new TenantModel();
        
        // Get current user info to pre-fill the form
        $userId = session()->get('id');
        
        // Get tenant with room information using the appropriate method
        $currentUser = $tenantModel->getTenantWithRoomInfo($userId);
        
        // Room information is now included in $currentUser
        $userRoom = null;
        if (!empty($currentUser['room_id'])) {
            $userRoom = [
                'room_id' => $currentUser['room_id'],
                'room_number' => $currentUser['room_number'],
                'bed_name' => $currentUser['bed_name']
            ];
        }
        
        $data = [
            'page_title' => 'Add Maintenance Request',
            'validation' => \Config\Services::validation(),
            'issueTypes' => $maintenanceModel->getIssueTypes(),
            'priorityLabels' => $maintenanceModel->getPriorityLabels(),
            'statusLabels' => $maintenanceModel->getStatusLabels(),
            'currentUser' => $currentUser,
            'userRoom' => $userRoom,
            'user_id' => $userId
        ];
        
        return 
            view('template/user/header') .
            view('User/add_maintenance', $data) .
            view('template/user/footer');
    }
    
    public function addMaintenance()
    {
        $maintenanceModel = new MaintenanceModel();
        $tenantModel = new TenantModel();
        
        // Get current user ID
        $userId = session()->get('id');
        
        // Get tenant info with room details
        $currentUser = $tenantModel->getTenantWithRoomInfo($userId);
        $roomId = $currentUser['room_id'] ?? null;
        
        if (!$roomId) {
            session()->setFlashdata('errors', 'No room assigned to your account. Please contact management.');
            return redirect()->to(base_url('User/maintenance/add'));
        }
        
        $data = [
            'resident_id' => $userId,
            'room_id' => $roomId,
            'issue_type' => $this->request->getPost('issue_type'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 0, // Default to pending
            'reported_date' => date('Y-m-d H:i:s'),
        ];
        
        if (!$maintenanceModel->insert($data)) {
            return redirect()->to(base_url('User/maintenance/add'))
                ->withInput()
                ->with('errors', $maintenanceModel->errors());
        }
        
        session()->setFlashdata('success', 'Maintenance request submitted successfully.');
        return redirect()->to(base_url('User/maintenance'));
    }
    
    public function editMaintenanceForm($id): string
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->find($id);
        $userId = session()->get('id');
        
        // Check if request belongs to current user
        if (!$maintenance || $maintenance['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only edit your own maintenance requests.');
            return redirect()->to(base_url('User/maintenance'));
        }
        
        $roomModel = new RoomModel();
        $tenantModel = new TenantModel();
        
        // Get current user info
        $currentUser = $tenantModel->find($userId);
        
        // Get user's room
        $userRoom = null;
        if (!empty($currentUser['room_id'])) {
            $userRoom = $roomModel->find($currentUser['room_id']);
        }
        
        // Get all rooms for the dropdown
        $rooms = $roomModel->findAll();
        
        // Add tenants data for the dropdown (we'll limit to just the current user)
        $tenants = [$currentUser]; // Just include the current user since users can only edit their own requests
        
        $data = [
            'page_title' => 'Edit Maintenance Request',
            'maintenance' => $maintenance,
            'validation' => \Config\Services::validation(),
            'issueTypes' => $maintenanceModel->getIssueTypes(),
            'priorityLabels' => $maintenanceModel->getPriorityLabels(),
            'statusLabels' => $maintenanceModel->getStatusLabels(),
            'currentUser' => $currentUser,
            'userRoom' => $userRoom,
            'tenants' => $tenants, // Add this line
            'rooms' => $rooms,     // Make sure rooms data is passed
        ];
        
        return 
            view('template/user/header') .
            view('User/edit_maintenance', $data) .
            view('template/user/footer');
    }
    
    public function updateMaintenance($id)
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->find($id);
        $userId = session()->get('id');
        
        // Check if request belongs to current user
        if (!$maintenance || $maintenance['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only update your own maintenance requests.');
            return redirect()->to(base_url('User/maintenance'));
        }
        
        $data = [
            'issue_type' => $this->request->getPost('issue_type'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
        ];
        
        // If status is changed to completed, set resolved_date
        if ($this->request->getPost('status') == '2' && $maintenance['status'] != '2') {
            $data['resolved_date'] = date('Y-m-d H:i:s');
        }
        
        if (!$maintenanceModel->update($id, $data)) {
            return redirect()->to(base_url("User/maintenance/edit/$id"))
                ->withInput()
                ->with('errors', $maintenanceModel->errors());
        }
        
        session()->setFlashdata('success', 'Maintenance request updated successfully.');
        return redirect()->to(base_url('User/maintenance'));
    }
    
    public function deleteMaintenance($id)
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->find($id);
        $userId = session()->get('id');
        
        // Check if request belongs to current user
        if (!$maintenance || $maintenance['resident_id'] != $userId) {
            session()->setFlashdata('error', 'You can only delete your own maintenance requests.');
            return redirect()->to(base_url('User/maintenance'));
        }
        
        // Check if the request can be deleted (e.g., only if status is pending)
        if ($maintenance['status'] != 0) {
            session()->setFlashdata('error', 'You can only delete pending maintenance requests.');
            return redirect()->to(base_url('User/maintenance'));
        }
        
        $maintenanceModel->delete($id);
        
        session()->setFlashdata('success', 'Maintenance request deleted successfully.');
        return redirect()->to(base_url('User/maintenance'));
    }
    
    public function announcement()
    {

        $announcementModel = new AnnouncementModel();
        $data['announcements'] = $announcementModel->findAll();

        return 
            view('template/user/header') .
            view('User/announcement', $data) .
            view('template/user/footer');
    }

    public function addAnnouncementForm(): string
    {
        $data = [
            'page_title' => 'Add Announcement',
            'validation' => \Config\Services::validation(),
        ];
        return 
            view('template/user/header') .
            view('User/add_announcement', $data) . 
            view('template/user/footer');
    }
    
    public function addAnnouncement()
    {
        $announcementModel = new AnnouncementModel();
    
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    
        if (!$announcementModel->insert($data)) {
            return redirect()->to(base_url('User/announcements/add'))
                ->withInput()
                ->with('errors', $announcementModel->errors());
        }
    
        session()->setFlashdata('success', 'Announcement added successfully.');
        return redirect()->to(base_url('User/announcements'));
    }
    
    public function updateAnnouncementForm($id): string
    {
        $announcementModel = new AnnouncementModel();
        $announcement = $announcementModel->find($id);
    
        if (!$announcement) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('User/announcements'));
        }
    
        $data = [
            'page_title' => 'Edit Announcement',
            'announcement' => $announcement,
            'validation' => \Config\Services::validation(),
        ];
    
        return 
            view('template/user/header') .
            view('User/edit_announcement', $data) .
            view('template/user/footer');
    }
    
    public function updateAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
    
        if (!$announcementModel->find($id)) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('User/announcements'));
        }
    
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    
        if (!$announcementModel->update($id, $data)) {
            return redirect()->to(base_url("announcements/edit/$id"))
                ->withInput()
                ->with('errors', $announcementModel->errors());
        }
    
        session()->setFlashdata('success', 'Announcement updated successfully.');
        return redirect()->to(base_url('User/announcements'));
    }
    
    public function deleteAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
    
        if (!$announcementModel->find($id)) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('User/announcements'));
        }
    
        $announcementModel->delete($id);
    
        session()->setFlashdata('success', 'Announcement deleted successfully.');
        return redirect()->to(base_url('User/announcements'));
    }
}