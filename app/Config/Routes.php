<?php

use CodeIgniter\Router\RouteCollection;

$routes->get('/', 'BoardingHouse::index');
$routes->post('/login', 'BoardingHouse::login');
$routes->get('/logout', 'BoardingHouse::logout');

// Admin side
$routes->get('/profile', 'BoardingHouse::profile', ['filter' => 'auth']);

$routes->get('/tenants', 'BoardingHouse::tenants', ['filter' => 'auth']);
$routes->get('/tenants/add', 'BoardingHouse::addTenantForm', ['filter' => 'auth']);
$routes->post('/tenants/add', 'BoardingHouse::addTenant', ['filter' => 'auth']);
$routes->get('/tenants/edit/(:num)', 'BoardingHouse::editTenantForm/$1', ['filter' => 'auth']);
$routes->post('/tenants/update/(:num)', 'BoardingHouse::updateTenant/$1', ['filter' => 'auth']);
$routes->get('/tenants/delete/(:num)', 'BoardingHouse::deleteTenant/$1', ['filter' => 'auth']);

$routes->get('/complaints', 'BoardingHouse::complaints', ['filter' => 'auth']);
$routes->get('/complaints/add', 'BoardingHouse::addComplaintForm', ['filter' => 'auth']);
$routes->post('/complaints/add', 'BoardingHouse::addComplaint', ['filter' => 'auth']);
$routes->get('/complaints/edit/(:num)', 'BoardingHouse::editComplaintForm/$1', ['filter' => 'auth']);
$routes->post('/complaints/update/(:num)', 'BoardingHouse::updateComplaint/$1', ['filter' => 'auth']);
$routes->get('/complaints/delete/(:num)', 'BoardingHouse::deleteComplaint/$1', ['filter' => 'auth']);

$routes->get('/feedbacks', 'BoardingHouse::feedbacks', ['filter' => 'auth']);
$routes->get('/feedbacks/add', 'BoardingHouse::addFeedbackForm', ['filter' => 'auth']);
$routes->post('/feedbacks/add', 'BoardingHouse::addFeedback', ['filter' => 'auth']);
$routes->get('/feedbacks/edit/(:num)', 'BoardingHouse::editFeedbackForm/$1', ['filter' => 'auth']);
$routes->post('/feedbacks/update/(:num)', 'BoardingHouse::updateFeedback/$1', ['filter' => 'auth']);
$routes->get('/feedbacks/delete/(:num)', 'BoardingHouse::deleteFeedback/$1', ['filter' => 'auth']);

$routes->get('/rooms', 'BoardingHouse::rooms', ['filter' => 'auth']);
$routes->get('/rooms/add', 'BoardingHouse::addRoomForm', ['filter' => 'auth']);
$routes->post('/rooms/add', 'BoardingHouse::addRoom', ['filter' => 'auth']);
$routes->get('/rooms/edit/(:num)', 'BoardingHouse::editRoomForm/$1', ['filter' => 'auth']);
$routes->post('/rooms/update/(:num)', 'BoardingHouse::updateRoom/$1', ['filter' => 'auth']);
$routes->get('/rooms/delete/(:num)', 'BoardingHouse::deleteRoom/$1', ['filter' => 'auth']);

$routes->get('/maintenance', 'BoardingHouse::maintenance', ['filter' => 'auth']);
$routes->get('/maintenance/add', 'BoardingHouse::addMaintenanceForm', ['filter' => 'auth']);
$routes->post('/maintenance/add', 'BoardingHouse::addMaintenance', ['filter' => 'auth']);
$routes->get('/maintenance/edit/(:num)', 'BoardingHouse::editMaintenanceForm/$1', ['filter' => 'auth']);
$routes->post('/maintenance/update/(:num)', 'BoardingHouse::updateMaintenance/$1', ['filter' => 'auth']);
$routes->get('/maintenance/delete/(:num)', 'BoardingHouse::deleteMaintenance/$1', ['filter' => 'auth']);

$routes->get('/announcements', 'BoardingHouse::announcement', ['filter' => 'auth']);
$routes->get('/announcements/add', 'BoardingHouse::addAnnouncementForm', ['filter' => 'auth']);
$routes->post('/announcements/add', 'BoardingHouse::addAnnouncement', ['filter' => 'auth']);
$routes->get('/announcements/edit/(:num)', 'BoardingHouse::updateAnnouncementForm/$1', ['filter' => 'auth']);
$routes->post('/announcements/update/(:num)', 'BoardingHouse::updateAnnouncement/$1', ['filter' => 'auth']);
$routes->get('/announcements/delete/(:segment)', 'BoardingHouse::deleteAnnouncement/$1', ['filter' => 'auth']);

// User side
$routes->get('/User/Dashboard', 'UserController::home', ['filter' => 'auth']);

$routes->get('/User/tenants', 'UserController::tenants', ['filter' => 'auth']);
$routes->get('/User/tenants/edit', 'UserController::editTenantForm', ['filter' => 'auth']);
$routes->post('/User/tenants/update', 'UserController::update', ['filter' => 'auth']);

$routes->get('/User/complaints', 'UserController::complaints', ['filter' => 'auth']);
$routes->get('/User/complaints/add', 'UserController::addComplaintForm', ['filter' => 'auth']);
$routes->post('/User/complaints/add', 'UserController::addComplaint', ['filter' => 'auth']);
$routes->get('/User/complaints/edit/(:num)', 'UserController::editComplaintForm/$1', ['filter' => 'auth']);
$routes->post('/User/complaints/update/(:num)', 'UserController::updateComplaint/$1', ['filter' => 'auth']);
$routes->get('/User/complaints/delete/(:num)', 'UserController::deleteComplaint/$1', ['filter' => 'auth']);

$routes->get('/User/feedbacks', 'UserController::feedbacks', ['filter' => 'auth']);
$routes->get('/User/feedbacks/add', 'UserController::addFeedbackForm', ['filter' => 'auth']);
$routes->post('/User/feedbacks/add', 'UserController::addFeedback', ['filter' => 'auth']);
$routes->get('/User/feedbacks/edit/(:num)', 'UserController::editFeedbackForm/$1', ['filter' => 'auth']);
$routes->post('/User/feedbacks/update/(:num)', 'UserController::updateFeedback/$1', ['filter' => 'auth']);
$routes->get('/User/feedbacks/delete/(:num)', 'UserController::deleteFeedback/$1', ['filter' => 'auth']);

$routes->get('/User/rooms', 'UserController::rooms', ['filter' => 'auth']);
$routes->get('/User/rooms/add', 'UserController::addRoomForm', ['filter' => 'auth']);
$routes->post('/User/rooms/add', 'UserController::addRoom', ['filter' => 'auth']);
$routes->get('/User/rooms/edit/(:num)', 'UserController::editRoomForm/$1', ['filter' => 'auth']);
$routes->post('/User/rooms/update/(:num)', 'UserController::updateRoom/$1', ['filter' => 'auth']);
$routes->get('/User/rooms/delete/(:num)', 'UserController::deleteRoom/$1', ['filter' => 'auth']);

$routes->get('/User/maintenance', 'UserController::maintenance', ['filter' => 'auth']);
$routes->get('/User/maintenance/add', 'UserController::addMaintenanceForm', ['filter' => 'auth']);
$routes->post('/User/maintenance/add', 'UserController::addMaintenance', ['filter' => 'auth']);
$routes->get('/User/maintenance/edit/(:num)', 'UserController::editMaintenanceForm/$1', ['filter' => 'auth']);
$routes->post('/User/maintenance/update/(:num)', 'UserController::updateMaintenance/$1', ['filter' => 'auth']);
$routes->get('/User/maintenance/delete/(:num)', 'UserController::deleteMaintenance/$1', ['filter' => 'auth']);

$routes->get('/User/announcements', 'UserController::announcement', ['filter' => 'auth']);
$routes->get('/User/announcements/add', 'UserController::addAnnouncementForm', ['filter' => 'auth']);
$routes->post('/User/announcements/add', 'UserController::addAnnouncement', ['filter' => 'auth']);
$routes->get('/User/announcements/edit/(:num)', 'UserController::updateAnnouncementForm/$1', ['filter' => 'auth']);
$routes->post('/User/announcements/update/(:num)', 'UserController::updateAnnouncement/$1', ['filter' => 'auth']);
$routes->get('/User/announcements/delete/(:segment)', 'UserController::deleteAnnouncement/$1', ['filter' => 'auth']);