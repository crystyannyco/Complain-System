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

class BoardingHouse extends BaseController
{
    public function index(): string
    {
        return view('login');
    }

    public function profile(): string
    {
        return 
        view('template/header').
        view('admin/profile');
        view('template/footer');
    }

    public function login()
    {
        $session = session();
        $AdminModel = new AdminModel();
        $TenantModel = new TenantModel(); 
        
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        $admin = $AdminModel->verifyLogin($email, $password);
        
        if ($admin) {
            $tenantData = [
                'id' => $admin['id'],
                'username' => $admin['username'],
                'email' => $admin['email'],
                'role' => 'admin',
                'isLoggedIn' => TRUE
            ];
            
            $session->set($tenantData);
            return redirect()->to('tenants');
        } 
        
        $tenant = $TenantModel->verifyLogin($email, $password);
        
        if ($tenant) {
            $tenantData = [
                'id' => $tenant['id'],
                'username' => $tenant['username'],
                'email' => $tenant['email'],
                'role' => 'tenant',
                'isLoggedIn' => TRUE
            ];
            
            $session->set($tenantData);
            return redirect()->to('User/Dashboard');
        }
        
        $session->setFlashdata('error', 'Email or Password is incorrect');
        return redirect()->to('/');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    public function tenants()
    {
        $TenantModel = new TenantModel();
        $tenants = $TenantModel->getTenantsWithRoomInfo();
    
        $data = [
            'page_title' => 'Tenants',
            'tenants' => $tenants,
            'validation' => \Config\Services::validation(),
        ];
    
        return 
            view('template/header').
            view('Admin/tenants', $data).
            view('template/footer');
    }

    public function addTenantForm(): string
    {
        $TenantModel = new TenantModel();
        
        $tenants = $TenantModel->getActiveTenants();
        
        $data = [
            'tenants' => $tenants,
            'validation' => \Config\Services::validation(),
        ];

        return 
            view('template/header').
            view('Admin/add_tenant', $data).
            view('template/footer');
    }

    public function addTenant()
    {
        $TenantModel = new TenantModel();

        // Get the form data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'phone' => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'birthdate' => $this->request->getPost('birthdate') ? date('Y-m-d', strtotime($this->request->getPost('birthdate'))) : null,
            'password' => $this->request->getPost('password'),
            'password_confirm' => $this->request->getPost('password_confirm'),
            'status' => '1',
            'last_login_at' => null,
        ];
        
        // Validate the data
        if (!$TenantModel->validate($data)) {
            return redirect()->to(base_url('tenants/add'))
                ->withInput()
                ->with('errors', $TenantModel->errors());
        }
        
        // Hash the password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Remove password_confirm before inserting
        unset($data['password_confirm']);
        
        if (!$TenantModel->insert($data)) {
            return redirect()->to(base_url('tenants/add'))
                ->withInput()
                ->with('errors', $TenantModel->errors());
        }

        session()->setFlashdata('success', 'Tenant added successfully.');
        return redirect()->to(base_url('tenants'));
    }

    public function editTenantForm($id): string
    {
        $tenantModel = new \App\Models\TenantModel();
        // Use only one method to get tenant data
        $tenant = $tenantModel->getTenantWithRoomInfo($id);
        
        if (!$tenant) {
            session()->setFlashdata('error', 'Tenant not found.');
            return redirect()->to(base_url('tenants'));
        }

        // Get all rooms for dropdown
        $roomModel = new \App\Models\RoomModel();
        $rooms = $roomModel->findAll();

        $data = [
            'page_title' => 'Edit Tenant',
            'tenant' => $tenant,
            'rooms' => $rooms,
            'validation' => \Config\Services::validation(),
        ];

        return view('template/header')
            . view('Admin/edit_tenant', $data)
            . view('template/footer');
    }

    public function updateTenant($id)
    {
        $tenantModel = new \App\Models\TenantModel();
    
        // Find current tenant data
        $currentTenant = $tenantModel->find($id);
        if (!$currentTenant) {
            session()->setFlashdata('error', 'Tenant not found.');
            return redirect()->to(base_url('tenants'));
        }
    
        // Get form inputs
        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
    
        // Build validation rules dynamically
        $rules = [
            'full_name' => 'required|min_length[3]',
            'phone'     => 'required|min_length[10]',
            'birthdate' => 'permit_empty',
        ];
    
        if ($username !== $currentTenant['username']) {
            $rules['username'] = 'required|min_length[3]|is_unique[users.username,id,' . $id . ']';
        } else {
            $rules['username'] = 'required|min_length[3]';
        }
    
        if ($email !== $currentTenant['email']) {
            $rules['email'] = 'required|valid_email|is_unique[users.email,id,' . $id . ']';
        } else {
            $rules['email'] = 'required|valid_email';
        }
    
        // Validate
        if (!$this->validate($rules)) {
            session()->setFlashdata('errors', $this->validator->getErrors());
            return redirect()->back()->withInput();
        }
    
        // Now call model's method
        if ($tenantModel->updateTenantProfile($id, $this->request)) {
            session()->setFlashdata('success', 'Tenant updated successfully.');
            return redirect()->to(base_url('tenants'));
        } else {
            session()->setFlashdata('error', 'Failed to update tenant. Please check your inputs.');
            return redirect()->back()->withInput();
        }
    }
    

    public function deleteTenant($id)
    {
        $tenantModel = new \App\Models\TenantModel();
        $roomModel = new \App\Models\RoomModel();
        
        $tenant = $tenantModel->find($id);
    
        if (!$tenant) {
            session()->setFlashdata('error', 'Tenant not found.');
            return redirect()->to(base_url('tenants'));
        }
    
        // Find rooms associated with this tenant
        $occupiedRooms = $roomModel->where('tenant_id', $id)->findAll();
        
        // Get database instance properly
        $db = \Config\Database::connect();
        
        // Begin transaction to ensure all operations succeed or fail together
        $db->transStart();
        
        // Update rooms to remove tenant association
        foreach ($occupiedRooms as $room) {
            $roomModel->update($room['room_id'], [
                'tenant_id' => null,
                'status' => 0, // Set to Available
                'move_out' => date('Y-m-d')
            ]);
        }
        
        // Delete the tenant
        $tenantModel->delete($id);
        
        // Complete transaction
        $db->transComplete();
        
        if ($db->transStatus() === false) {
            session()->setFlashdata('error', 'Failed to delete tenant. Please try again.');
            return redirect()->to(base_url('tenants'));
        }
        
        session()->setFlashdata('success', 'Tenant deleted successfully and room(s) updated to available.');
        return redirect()->to(base_url('tenants'));
    }


    public function rooms()
    {
        $RoomModel = new RoomModel();
        $rooms = $RoomModel->getRoomsWithStatusLabel();
    
        $data = [
            'page_title' => 'Room',
            'rooms' => $rooms,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/header').
            view('Admin/rooms', $data) .
            view('template/footer');
    }
    
    public function addRoomForm(): string
    {
        // Get all tenants for the dropdown
        $TenantModel = new \App\Models\TenantModel();
        $tenants = $TenantModel->getActiveTenants();
        
        $data = [
            'page_title' => 'Add Room',
            'validation' => \Config\Services::validation(),
            'tenants' => $tenants
        ];
    
        return 
            view('template/header').
            view('Admin/add_room', $data) .
            view('template/footer');
    }
    public function addRoom()
    {
        $RoomModel = new RoomModel();
        
        // Format dates properly if provided
        $moveInDate = $this->request->getPost('move_in') ? date('Y-m-d', strtotime($this->request->getPost('move_in'))) : null;
        $moveOutDate = $this->request->getPost('move_out') ? date('Y-m-d', strtotime($this->request->getPost('move_out'))) : null;
        
        $data = [
            'room_number' => $this->request->getPost('room_number'),
            'capacity' => $this->request->getPost('capacity'),
            'bed_name' => $this->request->getPost('bed_name'),
            'status' => $this->request->getPost('status'),
            'tenant_id' => $this->request->getPost('tenant_id') ?: null,
            'move_in' => $moveInDate,
            'move_out' => $moveOutDate
        ];
        
        if (!$RoomModel->insert($data)) {
            return redirect()->to(base_url('rooms/add'))
                ->withInput()
                ->with('errors', $RoomModel->errors());
        }
    
        session()->setFlashdata('success', 'Room added successfully.');
        return redirect()->to(base_url('rooms'));
    }
    
    
    public function editRoomForm($id): string
    {
        $RoomModel = new RoomModel();
        $room = $RoomModel->find($id);
        
        if (!$room) {
            session()->setFlashdata('error', 'Room not found.');
            return redirect()->to(base_url('rooms'));
        }
        
        // Get all tenants for the dropdown
        $TenantModel = new \App\Models\TenantModel();
        $tenants = $TenantModel->getActiveTenants();
        
        $data = [
            'page_title' => 'Edit Room',
            'room' => $room,
            'validation' => \Config\Services::validation(),
            'tenants' => $tenants
        ];
    
        return 
            view('template/header').
            view('Admin/edit_room', $data) .
            view('template/footer');
    }
    
    public function updateRoom($id)
    {
        $RoomModel = new RoomModel();
        
        if (!$RoomModel->find($id)) {
            session()->setFlashdata('error', 'Room not found.');
            return redirect()->to(base_url('rooms'));
        }
        
        // Format dates properly if provided
        $moveInDate = $this->request->getPost('move_in') ? date('Y-m-d', strtotime($this->request->getPost('move_in'))) : null;
        $moveOutDate = $this->request->getPost('move_out') ? date('Y-m-d', strtotime($this->request->getPost('move_out'))) : null;
        
        $data = [
            'room_number' => $this->request->getPost('room_number'),
            'capacity' => $this->request->getPost('capacity'),
            'bed_name' => $this->request->getPost('bed_name'),
            'status' => $this->request->getPost('status'),
            'tenant_id' => $this->request->getPost('tenant_id') ?: null,
            'move_in' => $moveInDate,
            'move_out' => $moveOutDate
        ];
    
        if (!$RoomModel->update($id, $data)) {
            return redirect()->to(base_url("rooms/edit/$id"))
                ->withInput()
                ->with('errors', $RoomModel->errors());
        }
    
        session()->setFlashdata('success', 'Room updated successfully.');
        return redirect()->to(base_url('rooms'));
    }

    public function deleteRoom($id)
    {
        $roomModel = new \App\Models\RoomModel();
        $room = $roomModel->find($id);

        if (!$room) {
            session()->setFlashdata('error', 'Room not found.');
            return redirect()->to(base_url('rooms'));
        }

        $roomModel->delete($id);
        session()->setFlashdata('success', 'Room deleted successfully.');
        return redirect()->to(base_url('rooms'));
    }
    
    public function complaints()
    {
        $complaintModel = new ComplaintModel();
        $complaints = $complaintModel->getComplaintsWithLabels();
        
        // Initialize an empty array if $complaints is null
        if ($complaints === null) {
            $complaints = [];
        }
        
        $data = [
            'page_title' => 'Complaints Management',
            'complaints' => $complaints,
        ];
        
        return 
            view('template/header') .
            view('Admin/complaints', $data) .
            view('template/footer');
    }

        
    public function editComplaintForm($id): string
    {
        $complaintModel = new ComplaintModel();
        
        // Get complaint with resident name and room info already joined
        $complaint = $complaintModel->getComplaintsWithLabels($id);
        
        if (!$complaint) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('complaints'));
        }
        
        // Make sure room formatting exists
        if (!isset($complaint['room'])) {
            // Format room information if it's not already set
            if (!empty($complaint['room_number']) && !empty($complaint['bed_name'])) {
                $complaint['room'] = $complaint['room_number'] . ' - ' . $complaint['bed_name'];
            } elseif (!empty($complaint['room_number'])) {
                $complaint['room'] = $complaint['room_number'];
            } else {
                $complaint['room'] = 'Not Assigned';
            }
        }
        
        $data = [
            'page_title' => 'Edit Complaint',
            'complaint' => $complaint,
            'complaintTypes' => $complaintModel->getComplaintTypes(),
            'validation' => \Config\Services::validation(),
            'complaintTypeText' => $complaintModel->getComplaintTypeText($complaint['type_id'] ?? $complaint['type'])
        ];
        
        return 
            view('template/header') .
            view('Admin/edit_complaint', $data) .
            view('template/footer');
    }
    
    public function updateComplaint($id)
    {
        $complaintModel = new ComplaintModel();
        
        if (!$complaintModel->find($id)) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('complaints'));
        }
        
        $data = [
            'resident_id' => $this->request->getPost('resident_id'),
            'type' => $this->request->getPost('type'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
        ];
        
        if (!$complaintModel->update($id, $data)) {
            return redirect()->to(base_url("complaints/edit/$id"))
                ->withInput()
                ->with('errors', $complaintModel->errors());
        }
        
        session()->setFlashdata('success', 'Complaint updated successfully.');
        return redirect()->to(base_url('complaints'));
    }
    
    public function deleteComplaint($id)
    {
        $complaintModel = new ComplaintModel();
        
        if (!$complaintModel->find($id)) {
            session()->setFlashdata('error', 'Complaint not found.');
            return redirect()->to(base_url('complaints'));
        }
        
        $complaintModel->delete($id);
        
        session()->setFlashdata('success', 'Complaint deleted successfully.');
        return redirect()->to(base_url('complaints'));
    }


    public function feedbacks()
    {
        $feedbackModel = new FeedbackModel();
        $feedback = $feedbackModel->getFeedbackWithLabels();
        
        $data = [
            'page_title' => 'Feedback',
            'feedback' => $feedback,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/header') .
            view('Admin/feedbacks', $data) .
            view('template/footer');
    }

    public function deleteFeedback($id)
    {
        $feedbackModel = new FeedbackModel();
        
        if (!$feedbackModel->find($id)) {
            session()->setFlashdata('error', 'Feedback not found.');
            return redirect()->to(base_url('feedbacks'));
        }
        
        $feedbackModel->delete($id);
        
        session()->setFlashdata('success', 'Feedback deleted successfully.');
        return redirect()->to(base_url('feedbacks'));
    }
    
    public function maintenance()
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->getMaintenanceWithRoom();
        
        $data = [
            'page_title' => 'Maintenance',
            'maintenance' => $maintenance,
            'validation' => \Config\Services::validation(),
        ];
        
        return 
            view('template/header') .
            view('Admin/maintenance', $data) .
            view('template/footer');
    }

    public function addMaintenanceForm(): string
    {
        $maintenanceModel = new MaintenanceModel();
        $roomModel = new RoomModel();
        $tenantModel = new TenantModel();
        
        $data = [
            'page_title' => 'Add Maintenance Request',
            'validation' => \Config\Services::validation(),
            'issueTypes' => $maintenanceModel->getIssueTypes(),
            'priorityLabels' => $maintenanceModel->getPriorityLabels(),
            'statusLabels' => $maintenanceModel->getStatusLabels(),
            'rooms' => $roomModel->findAll(),
            'tenants' => $tenantModel->getTenantsWithRoomInfo(), // Use this method instead
        ];
        
        return 
            view('template/header') .
            view('Admin/add_maintenance', $data) .
            view('template/footer');
    }

    public function addMaintenance()
    {
        $maintenanceModel = new MaintenanceModel();
        
        $data = [
            'resident_id' => $this->request->getPost('resident_id'),
            'room_id' => $this->request->getPost('room_id'),
            'issue_type' => $this->request->getPost('issue_type'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => 0, // Default to pending
            'reported_date' => date('Y-m-d H:i:s'),
            'assigned_to' => $this->request->getPost('assigned_to') ?: null,
            'notes' => $this->request->getPost('notes') ?: null,
        ];
        
        if (!$maintenanceModel->insert($data)) {
            return redirect()->to(base_url('maintenance/add'))
                ->withInput()
                ->with('errors', $maintenanceModel->errors());
        }
        
        session()->setFlashdata('success', 'Maintenance request submitted successfully.');
        return redirect()->to(base_url('maintenance'));
    }

    public function editMaintenanceForm($id): string
    {
        $maintenanceModel = new MaintenanceModel();
        $maintenance = $maintenanceModel->find($id);
        
        if (!$maintenance) {
            session()->setFlashdata('error', 'Maintenance request not found.');
            return redirect()->to(base_url('maintenance'));
        }
        
        $roomModel = new RoomModel();
        $tenantModel = new TenantModel();
        
        $data = [
            'page_title' => 'Edit Maintenance Request',
            'maintenance' => $maintenance,
            'validation' => \Config\Services::validation(),
            'issueTypes' => $maintenanceModel->getIssueTypes(),
            'priorityLabels' => $maintenanceModel->getPriorityLabels(),
            'statusLabels' => $maintenanceModel->getStatusLabels(),
            'rooms' => $roomModel->findAll(),
            'tenants' => $tenantModel->getActiveTenants(),
        ];
        
        return 
            view('template/header') .
            view('Admin/edit_maintenance', $data) .
            view('template/footer');
    }

    public function updateMaintenance($id)
    {
        $maintenanceModel = new MaintenanceModel();
        
        if (!$maintenanceModel->find($id)) {
            session()->setFlashdata('error', 'Maintenance request not found.');
            return redirect()->to(base_url('maintenance'));
        }
        
        $data = [
            'resident_id' => $this->request->getPost('resident_id'),
            'room_id' => $this->request->getPost('room_id'),
            'issue_type' => $this->request->getPost('issue_type'),
            'description' => $this->request->getPost('description'),
            'priority' => $this->request->getPost('priority'),
            'status' => $this->request->getPost('status'),
            'assigned_to' => $this->request->getPost('assigned_to') ?: null,
            'notes' => $this->request->getPost('notes') ?: null,
        ];
        
        // If status changed to Completed, add resolved date
        if ($this->request->getPost('status') == 2) {
            $data['resolved_date'] = date('Y-m-d H:i:s');
        }
        
        if (!$maintenanceModel->update($id, $data)) {
            return redirect()->to(base_url("maintenance/edit/$id"))
                ->withInput()
                ->with('errors', $maintenanceModel->errors());
        }
        
        session()->setFlashdata('success', 'Maintenance request updated successfully.');
        return redirect()->to(base_url('maintenance'));
    }

    public function deleteMaintenance($id)
    {
        $maintenanceModel = new MaintenanceModel();
        
        if (!$maintenanceModel->find($id)) {
            session()->setFlashdata('error', 'Maintenance request not found.');
            return redirect()->to(base_url('maintenance'));
        }
        
        $maintenanceModel->delete($id);
        
        session()->setFlashdata('success', 'Maintenance request deleted successfully.');
        return redirect()->to(base_url('maintenance'));
    }
    
    public function announcement()
    {

        $announcementModel = new AnnouncementModel();
        $data['announcements'] = $announcementModel->findAll();

        return 
            view('template/header') .
            view('Admin/announcement', $data) .
            view('template/footer');
    }

    // SHOW ADD FORM
    public function addAnnouncementForm(): string
    {
        $data = [
            'page_title' => 'Add Announcement',
            'validation' => \Config\Services::validation(),
        ];
        return 
            view('template/header') .
            view('Admin/add_announcement', $data) . 
            view('template/footer');
    }
    
    // SAVE NEW ANNOUNCEMENT
    public function addAnnouncement()
    {
        $announcementModel = new AnnouncementModel();
    
        $data = [
            'title' => $this->request->getPost('title'),
            'content' => $this->request->getPost('content'),
            'created_at' => date('Y-m-d H:i:s'),
        ];
    
        if (!$announcementModel->insert($data)) {
            return redirect()->to(base_url('announcements/add'))
                ->withInput()
                ->with('errors', $announcementModel->errors());
        }
    
        session()->setFlashdata('success', 'Announcement added successfully.');
        return redirect()->to(base_url('announcements'));
    }
    
    // SHOW EDIT FORM
    public function updateAnnouncementForm($id): string
    {
        $announcementModel = new AnnouncementModel();
        $announcement = $announcementModel->find($id);
    
        if (!$announcement) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('announcements'));
        }
    
        $data = [
            'page_title' => 'Edit Announcement',
            'announcement' => $announcement,
            'validation' => \Config\Services::validation(),
        ];
    
        return 
            view('template/header') .
            view('Admin/edit_announcement', $data) .
            view('template/footer');
    }
    
    // UPDATE ANNOUNCEMENT
    public function updateAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
    
        if (!$announcementModel->find($id)) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('announcements'));
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
        return redirect()->to(base_url('announcements'));
    }
    
    // DELETE ANNOUNCEMENT
    public function deleteAnnouncement($id)
    {
        $announcementModel = new AnnouncementModel();
    
        if (!$announcementModel->find($id)) {
            session()->setFlashdata('error', 'Announcement not found.');
            return redirect()->to(base_url('announcements'));
        }
    
        $announcementModel->delete($id);
    
        session()->setFlashdata('success', 'Announcement deleted successfully.');
        return redirect()->to(base_url('announcements'));
    }
}