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

            <!-- Maintenance List -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Maintenance Requests</h2>
                    <!-- <a href="<?= base_url('maintenance/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">add</span>
                        Add Maintenance Request
                    </a> -->
                </div>

                <!-- Maintenance Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resident</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Type</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($maintenance)): ?>
                                <?php foreach ($maintenance as $item): ?>
                                    <?php
                                        $priorityClass = match((int)$item['priority']) {
                                            3 => 'bg-red-100 text-red-800',
                                            2 => 'bg-orange-100 text-orange-800',
                                            default => 'bg-blue-100 text-blue-800'
                                        };
                                        
                                        $statusClass = match($item['status_text']) {
                                            'Pending' => 'bg-yellow-100 text-yellow-800',
                                            'In Progress' => 'bg-blue-100 text-blue-800',
                                            'Completed' => 'bg-green-100 text-green-800',
                                            'Denied' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        };

                                        // Truncate issue type and description
                                        $truncatedIssueType = strlen($item['issue_type_text']) > 20 ? substr($item['issue_type_text'], 0, 20) . '...' : $item['issue_type_text'];
                                        $truncatedDescription = strlen($item['description']) > 20 ? substr($item['description'], 0, 20) . '...' : $item['description'];
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            Room <?= esc($item['room_number'] ?? 'Unknown') ?> 
                                            <?= !empty($item['bed_name']) ? '(' . esc($item['bed_name']) . ')' : '' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($item['resident_name'] ?? 'Unknown') ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap" title="<?= esc($item['issue_type_text']) ?>"><?= esc($truncatedIssueType) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                <?= esc(explode(' -', $item['priority_text'])[0]) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                <?= esc($item['status_text']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?= date('M d, Y', strtotime($item['reported_date'])) ?>
                                        </td>
                                        <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button data-maintenance-id="<?= $item['maintenance_id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3 open-modal flex items-center">
                                                <span class="mr-1 material-icons">visibility</span>View
                                            </button>
                                            <a href="<?= base_url('maintenance/edit/' . $item['maintenance_id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 flex items-center">
                                                <span class="mr-1 material-icons">edit</span>Edit
                                            </a>
                                            <a href="<?= base_url('maintenance/delete/' . $item['maintenance_id']) ?>" class="text-red-600 hover:text-red-900 flex items-center" onclick="return confirm('Are you sure you want to delete this maintenance request?')">
                                                <span class="mr-1 material-icons">delete</span>Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No maintenance requests found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Modals Section -->
                <?php foreach ($maintenance as $item): ?>
                    <?php
                        $priorityClass = match((int)$item['priority']) {
                            3 => 'bg-red-100 text-red-800',
                            2 => 'bg-orange-100 text-orange-800',
                            default => 'bg-blue-100 text-blue-800'
                        };
                        
                        $statusClass = match($item['status_text']) {
                            'Pending' => 'bg-yellow-100 text-yellow-800',
                            'In Progress' => 'bg-blue-100 text-blue-800',
                            'Completed' => 'bg-green-100 text-green-800',
                            'Denied' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    ?>
                    <div id="modal-<?= $item['maintenance_id'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                        <div class="flex items-center justify-center min-h-screen px-4">
                            <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content">
                                <div class="rounded-t-lg p-6 border-b flex justify-between items-center <?= str_replace('text', 'bg', $statusClass) ?> bg-opacity-40">
                                    <h3 class="text-xl font-bold text-gray-800 flex items-center">
                                        <span class="material-icons mr-2">build</span>Maintenance Request Details
                                    </h3>
                                    <button class="text-gray-600 hover:text-gray-900 hover:bg-gray-200 rounded-full p-1 close-modal" data-maintenance-id="<?= $item['maintenance_id'] ?>">
                                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-6">
                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Location Information</h4>
                                        <div class="space-y-2 mb-3">
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Room:</span>
                                                <span class="text-gray-800">
                                                    Room <?= esc($item['room_number'] ?? 'Unknown') ?> 
                                                    <?= !empty($item['bed_name']) ? '(' . esc($item['bed_name']) . ')' : '' ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Resident:</span>
                                                <span class="text-gray-800"><?= esc($item['resident_name'] ?? 'Unknown') ?></span>
                                            </div>
                                        </div>
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Issue Details</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Type:</span>
                                                <span class="text-gray-800"><?= esc($item['issue_type_text']) ?></span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Priority:</span>
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                    <?= esc($item['priority_text']) ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Status:</span>
                                                <span class="px-2 inline-flex text-sm leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                    <?= esc($item['status_text']) ?>
                                                </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Reported:</span>
                                                <span class="text-gray-800"><?= date('M d, Y h:i A', strtotime($item['reported_date'])) ?></span>
                                            </div>
                                            <?php if(!empty($item['resolved_date'])): ?>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Resolved:</span>
                                                <span class="text-gray-800">
                                                    <?= !empty($item['resolved_date']) ? date('M d, Y h:i A', strtotime($item['resolved_date'])) : '-------' ?>
                                                </span>
                                            </div>
                                            <?php endif; ?>
                                            <?php if(!empty($item['assigned_to'])): ?>
                                            <div class="flex items-center">
                                                <span class="text-gray-600 font-medium w-24">Assigned To:</span>
                                                <span class="text-gray-800"><?= esc($item['assigned_to']) ?></span>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Description</h4>
                                        <div class="text-gray-800 whitespace-pre-wrap"><?= esc($item['description']) ?></div>
                                    </div>

                                    <?php if(!empty($item['notes'])): ?>
                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Notes</h4>
                                        <div class="text-gray-800 whitespace-pre-wrap"><?= esc($item['notes']) ?></div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="mt-6 border-t pt-4 flex justify-between">
                                        <a href="<?= base_url('maintenance/edit/' . $item['maintenance_id']) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center">
                                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>Edit Request
                                        </a>
                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center close-modal" data-maintenance-id="<?= $item['maintenance_id'] ?>">
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
            const id = btn.getAttribute('data-maintenance-id');
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
            closeModal(btn.getAttribute('data-maintenance-id'));
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
</script>