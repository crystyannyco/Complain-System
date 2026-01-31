<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Tenants List -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Tenant Management</h2>
                    <a href="<?= base_url('tenants/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">add</span>
                        Add New Tenant
                    </a>
                </div>

                <!-- Tenants Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bed</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($tenants)): ?>
                                <?php foreach ($tenants as $tenant): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($tenant['full_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($tenant['phone']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($tenant['room_number'] ?? '—') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($tenant['bed_name'] ?? '—') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $statusClass = match((string)$tenant['status']) {
                                                '1', 'active' => 'bg-green-100 text-green-800',
                                                '0', 'inactive' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800',
                                            };                                            
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                <?= esc($tenant['status_label'] ?? '—') ?>
                                            </span>
                                        </td>
                                        <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button data-tenant-id="<?= $tenant['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3 open-modal transition duration-300 ease-in-out flex items-center">
                                                <span class="mr-1 material-icons">visibility</span>
                                                View
                                            </button>
                                            <a href="<?= base_url('tenants/edit/'.$tenant['id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-300 ease-in-out flex items-center inline-flex">
                                                <span class="mr-1 material-icons">edit</span>
                                                Edit
                                            </a>
                                            <a href="<?= base_url('tenants/delete/'.$tenant['id']) ?>" class="text-red-600 hover:text-red-900 transition duration-300 ease-in-out flex items-center inline-flex" onclick="return confirm('Are you sure you want to delete this tenant?')">
                                                <span class="mr-1 material-icons">delete</span>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal for each tenant -->
                                    <div id="modal-<?= $tenant['id'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                                        <div class="flex items-center justify-center min-h-screen px-4">
                                            <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content">
                                                <!-- Header with color based on status -->
                                                <div class="rounded-t-lg p-6 border-b flex justify-between items-center <?= str_replace('text', 'bg', $statusClass) ?> bg-opacity-40">
                                                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                                        <span class="material-icons mr-2">person</span>
                                                        Tenant Details
                                                    </h3>
                                                    <button class="text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded-full p-1 transition duration-200 ease-in-out close-modal" data-tenant-id="<?= $tenant['id'] ?>">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Content -->
                                                <div class="p-6">
                                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                                                        <div class="bg-gray-50 p-4 rounded-lg">
                                                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Personal Information</h4>
                                                            <div class="space-y-2">
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Username:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['username']) ?></span>
                                                                </div>

                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Name:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['full_name']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Email:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['email']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Phone:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['phone']) ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                                                        <div class="bg-gray-50 p-4 rounded-lg">
                                                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Accommodation Details</h4>
                                                            <div class="space-y-2">
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Room:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['room_number'] ?? '—') ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Bed:</span>
                                                                    <span class="text-gray-800"><?= esc($tenant['bed_name'] ?? '—') ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Move In:</span>
                                                                    <span class="text-gray-800"><?= !empty($tenant['move_in']) ? date('M d, Y', strtotime($tenant['move_in'])) : '—' ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Move Out:</span>
                                                                    <span class="text-gray-800"><?= !empty($tenant['move_out']) ? date('M d, Y', strtotime($tenant['move_out'])) : '—' ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Status:</span>
                                                                    <span class="px-2 inline-flex text-s leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                                        <?= esc($tenant['status_label'] ?? '—') ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action Section -->
                                                    <div class="mt-6 border-t pt-4 flex justify-between">
                                                        <a href="<?= base_url('tenants/edit/'.$tenant['id']) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition duration-300 ease-in-out">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                            Edit Tenant
                                                        </a>
                                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center transition duration-300 ease-in-out close-modal" data-tenant-id="<?= $tenant['id'] ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            Close
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Open modal function with animation
    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-tenant-id');
            const modal = document.getElementById(`modal-${id}`);
            const modalContent = modal.querySelector('.modal-content');
            
            // Display the modal background first
            modal.classList.remove('hidden');
            
            // Slight delay for the transition to work properly
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            
            // Prevent background scrolling
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal function with animation
    function closeModal(modalId) {
        const modal = document.getElementById(`modal-${modalId}`);
        const modalContent = modal.querySelector('.modal-content');
        
        // Animate out
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        
        // Delay hiding the modal until animation completes
        setTimeout(() => {
            modal.classList.add('hidden');
            // Re-enable scrolling
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Attach close function to buttons
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-tenant-id');
            closeModal(id);
        });
    });

    // Close modal when clicking outside the content
    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                const id = modal.id.replace('modal-', '');
                closeModal(id);
            }
        });
    });

    // Close modal with ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(modal => {
                const id = modal.id.replace('modal-', '');
                closeModal(id);
            });
        }
    });
</script>