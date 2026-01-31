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

            <!-- Complaints List -->
            <div class="bg-white rounded-lg shadow-lg p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Complaints</h2>
                    <a href="<?= base_url('User/complaints/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center whitespace-nowrap">
                        <span class="material-icons mr-1">add</span>
                        Add Complaint
                    </a>
                </div>

                <!-- Complaints Table (desktop) / Cards (mobile) -->
                <div>
                    <!-- Desktop Table (hidden on small screens) -->
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($complaints)): ?>
                                    <?php foreach ($complaints as $complaint): ?>
                                        <?php
                                            $complaintId = $complaint['complaint_id'] ?? $complaint['type_id'] ?? $complaint['type'];

                                            // Priority display based on priority_label field from the model
                                            $priorityLabel = $complaint['priority_label'] ?? 'Low (Level 1) - Minor Issues';
                                            $priority = strtolower(explode(' ', $priorityLabel)[0]); // Get just the "Low", "Medium", or "High" part
                                            
                                            $priorityClass = match($priority) {
                                                'high' => 'bg-red-100 text-red-800',
                                                'medium' => 'bg-orange-100 text-orange-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                            $priorityText = ucfirst($priority);

                                            $statusClass = match($complaint['status']) {
                                                'Pending' => 'bg-yellow-100 text-yellow-800',
                                                'In Progress' => 'bg-blue-100 text-blue-800',
                                                'Resolved' => 'bg-green-100 text-green-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap"><?= esc($complaint['type']) ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap max-w-xs truncate" title="<?= esc($complaint['description']) ?>">
                                                <?= esc($complaint['description']) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                    <?= $priorityText ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                    <?= esc($complaint['status']) ?>
                                                </span>
                                            </td>
                                            <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <button data-complaint-id="<?= $complaintId ?>" class="text-blue-600 hover:text-blue-900 mr-3 open-modal flex items-center">
                                                    <span class="mr-1 material-icons">visibility</span>View
                                                </button>
                                                <a href="<?= base_url('User/complaints/edit/' . $complaintId) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 flex items-center">
                                                    <span class="mr-1 material-icons">edit</span>Edit
                                                </a>
                                                <a href="<?= base_url('User/complaints/delete/' . $complaintId) ?>" class="text-red-600 hover:text-red-900 flex items-center" onclick="return confirm('Are you sure you want to delete this complaint?')">
                                                    <span class="mr-1 material-icons">delete</span>Delete
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No complaints found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards (shown only on small screens) -->
                    <div class="md:hidden">
                        <?php if (!empty($complaints)): ?>
                            <div class="grid grid-cols-1 gap-4">
                                <?php foreach ($complaints as $complaint): ?>
                                    <?php
                                        $complaintId = $complaint['complaint_id'] ?? $complaint['type_id'] ?? $complaint['type'];

                                        // Priority display based on priority_label field from the model
                                        $priorityLabel = $complaint['priority_label'] ?? 'Low (Level 1) - Minor Issues';
                                        $priority = strtolower(explode(' ', $priorityLabel)[0]); // Get just the "Low", "Medium", or "High" part
                                        
                                        $priorityClass = match($priority) {
                                            'high' => 'bg-red-100 text-red-800',
                                            'medium' => 'bg-orange-100 text-orange-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                        $priorityText = ucfirst($priority);

                                        $statusClass = match($complaint['status']) {
                                            'Pending' => 'bg-yellow-100 text-yellow-800',
                                            'In Progress' => 'bg-blue-100 text-blue-800',
                                            'Resolved' => 'bg-green-100 text-green-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };

                                        $cardBorderClass = match($complaint['status']) {
                                            'Pending' => 'border-l-4 border-yellow-400',
                                            'In Progress' => 'border-l-4 border-blue-400',
                                            'Resolved' => 'border-l-4 border-green-400',
                                            default => 'border-l-4 border-gray-300'
                                        };
                                    ?>
                                    <div class="bg-white shadow rounded-lg <?= $cardBorderClass ?> overflow-hidden">
                                        <div class="px-4 py-3 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                                            <h3 class="text-sm font-medium text-gray-800"><?= esc($complaint['type']) ?></h3>
                                            <div class="flex space-x-1">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                    <?= $priorityText ?>
                                                </span>
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                    <?= esc($complaint['status']) ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <div class="text-sm text-gray-600 mb-4 line-clamp-2" title="<?= esc($complaint['description']) ?>">
                                                <?= esc($complaint['description']) ?>
                                            </div>
                                            <div class="flex justify-between pt-2 border-t border-gray-100">
                                                <button data-complaint-id="<?= $complaintId ?>" class="text-blue-600 hover:text-blue-900 text-sm open-modal flex items-center">
                                                    <span class="mr-1 material-icons text-sm">visibility</span>View
                                                </button>
                                                <a href="<?= base_url('User/complaints/edit/' . $complaintId) ?>" class="text-indigo-600 hover:text-indigo-900 text-sm flex items-center">
                                                    <span class="mr-1 material-icons text-sm">edit</span>Edit
                                                </a>
                                                <a href="<?= base_url('User/complaints/delete/' . $complaintId) ?>" class="text-red-600 hover:text-red-900 text-sm flex items-center" onclick="return confirm('Are you sure you want to delete this complaint?')">
                                                    <span class="mr-1 material-icons text-sm">delete</span>Delete
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-8 text-gray-500">No complaints found</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Modals Section -->
                <?php foreach ($complaints as $complaint): ?>
                    <?php
                        $complaintId = $complaint['complaint_id'] ?? $complaint['type_id'] ?? $complaint['type'];
                        
                        // Priority display based on priority_label field from the model
                        $priorityLabel = $complaint['priority_label'] ?? 'Low (Level 1) - Minor Issues';
                        $priority = strtolower(explode(' ', $priorityLabel)[0]); // Get just the "Low", "Medium", or "High" part
                        
                        $priorityClass = match($priority) {
                            'high' => 'bg-red-100 text-red-800',
                            'medium' => 'bg-orange-100 text-orange-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                        $priorityText = $priorityLabel; // Use the full priority label in the modal

                        $statusClass = match($complaint['status']) {
                            'Pending' => 'bg-yellow-100 text-yellow-800',
                            'In Progress' => 'bg-blue-100 text-blue-800',
                            'Resolved' => 'bg-green-100 text-green-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    ?>
                    <div id="modal-<?= $complaintId ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                        <div class="flex items-end sm:items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                            <div class="bg-white w-full max-w-lg mx-auto rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content sm:my-8">
                                <div class="rounded-t-lg p-4 sm:p-6 border-b flex justify-between items-center <?= str_replace('text', 'bg', $statusClass) ?> bg-opacity-40">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-800 flex items-center">
                                        <span class="material-icons mr-2">feedback</span>Complaint Details
                                    </h3>
                                    <button class="text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded-full p-1 close-modal" data-complaint-id="<?= $complaintId ?>">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-4 sm:p-6">
                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Resident Information</h4>
                                        <div class="space-y-2 mb-3">
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Tenant:</span>
                                                <span class="text-gray-800"><?= esc($complaint['resident_name'] ?? 'Unknown') ?></span>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Room:</span>
                                                <span class="text-gray-800"><?= esc($complaint['room'] ?? 'N/A') ?></span>
                                            </div>
                                        </div>
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Complaint Info</h4>
                                        <div class="space-y-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Type:</span>
                                                <span class="text-gray-800"><?= esc($complaint['type']) ?></span>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Priority:</span>
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                    <?= esc($priorityText) ?>
                                                </span>
                                            </div>
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Status:</span>
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                    <?= esc($complaint['status']) ?>
                                                </span>
                                            </div>
                                            <?php if(isset($complaint['created_at'])): ?>
                                            <div class="flex flex-col sm:flex-row sm:items-center">
                                                <span class="text-gray-600 font-medium w-24">Created:</span>
                                                <span class="text-gray-800"><?= esc($complaint['created_at']) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Description</h4>
                                        <div class="text-gray-800 whitespace-pre-wrap"><?= esc($complaint['description']) ?></div>
                                    </div>

                                    <div class="mt-6 border-t pt-4 flex flex-col sm:flex-row gap-2 sm:justify-between">
                                        <a href="<?= base_url('User/complaints/edit/'.$complaintId) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center justify-center">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>Edit Complaint
                                        </a>
                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center justify-center close-modal" data-complaint-id="<?= $complaintId ?>">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
</div>

<script>
    // Open modal
    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-complaint-id');
            const modal = document.getElementById(`modal-${id}`);
            const modalContent = modal.querySelector('.modal-content');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        });
    });

    // Close modal
    function closeModal(id) {
        const modal = document.getElementById(`modal-${id}`);
        const modalContent = modal.querySelector('.modal-content');
        modalContent.classList.remove('scale-100', 'opacity-100');
        modalContent.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            closeModal(btn.getAttribute('data-complaint-id'));
        });
    });

    document.querySelectorAll('[id^="modal-"]').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal(modal.id.replace('modal-', ''));
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(modal => {
                closeModal(modal.id.replace('modal-', ''));
            });
        }
    });

    // Add line clamping for mobile descriptions (requires Tailwind CSS v2.0+)
    if (!('lineCamp' in document.documentElement.style)) {
        document.querySelectorAll('.line-clamp-2').forEach(el => {
            el.style.overflow = 'hidden';
            el.style.display = '-webkit-box';
            el.style.webkitBoxOrient = 'vertical';
            el.style.webkitLineClamp = '2';
        });
    }
</script>