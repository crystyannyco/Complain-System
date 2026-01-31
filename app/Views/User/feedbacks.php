<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-4 px-2 sm:py-6 sm:px-6 lg:px-8">
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
        
            <!-- Feedback List -->
            <div class="bg-white rounded-lg shadow-lg p-3 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">My Feedback</h2>
                    <a href="<?= base_url('User/feedbacks/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center justify-center sm:justify-start">
                        <span class="material-icons mr-1">add</span>
                        Add Feedback
                    </a>
                </div>
                
                <!-- Feedback Table - Desktop View -->
                <div class="hidden sm:block overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 sm:px-6 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                <th class="px-4 py-2 sm:px-6 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-2 sm:px-6 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-4 py-2 sm:px-6 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-4 py-2 sm:px-6 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($feedback)): ?>
                                <?php foreach ($feedback as $item): ?>
                                    <?php
                                    // Determine priority based on level
                                    $priorityClass = '';
                                    $priorityText = '';
                                    
                                    if ($item['level'] == 1) {
                                        $priorityClass = 'bg-green-100 text-green-800'; // Positive feedback
                                        $priorityText = 'Positive';
                                    } elseif ($item['level'] == 2) {
                                        $priorityClass = 'bg-yellow-100 text-yellow-800'; // Neutral feedback
                                        $priorityText = 'Neutral';
                                    } elseif ($item['level'] == 3) {
                                        $priorityClass = 'bg-red-100 text-red-800'; // Negative feedback
                                        $priorityText = 'Negative';
                                    } else {
                                        $priorityClass = 'bg-gray-100 text-gray-800';
                                        $priorityText = 'Unknown';
                                    }
                                    ?>
                                    <tr>
                                        <td class="px-4 py-2 sm:px-6 sm:py-4 whitespace-nowrap"><?= esc($item['type']) ?></td>
                                        <td class="px-4 py-2 sm:px-6 sm:py-4">
                                            <?= strlen($item['description']) > 50 ? esc(substr($item['description'], 0, 50) . '...') : esc($item['description']) ?>
                                        </td>
                                        <td class="px-4 py-2 sm:px-6 sm:py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                <?= $priorityText ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 sm:px-6 sm:py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                                <?= date('M d, Y', strtotime($item['created_at'])) ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-2 sm:px-6 sm:py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <button data-feedback-id="<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900 open-modal flex items-center transition duration-300 ease-in-out">
                                                    <span class="material-icons mr-1" style="font-size:18px;">visibility</span>
                                                    <span class="hidden sm:inline">View</span>
                                                </button>
                                                <a href="<?= base_url('User/feedbacks/edit/'.$item['id']) ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center transition duration-300 ease-in-out">
                                                    <span class="material-icons mr-1" style="font-size:18px;">edit</span>
                                                    <span class="hidden sm:inline">Edit</span>
                                                </a>
                                                <a href="<?= base_url('User/feedbacks/delete/'.$item['id']) ?>" onclick="return confirm('Are you sure you want to delete this feedback?')" class="text-red-600 hover:text-red-900 flex items-center transition duration-300 ease-in-out">
                                                    <span class="material-icons mr-1" style="font-size:18px;">delete</span>
                                                    <span class="hidden sm:inline">Delete</span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">You haven't submitted any feedback yet</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Feedback Cards - Mobile View -->
                <div class="sm:hidden space-y-4">
                    <?php if (!empty($feedback)): ?>
                        <?php foreach ($feedback as $item): ?>
                            <?php
                            // Determine priority based on level
                            $priorityClass = '';
                            $priorityText = '';
                            
                            if ($item['level'] == 1) {
                                $priorityClass = 'bg-green-100 text-green-800'; // Positive feedback
                                $priorityText = 'Positive';
                            } elseif ($item['level'] == 2) {
                                $priorityClass = 'bg-yellow-100 text-yellow-800'; // Neutral feedback
                                $priorityText = 'Neutral';
                            } elseif ($item['level'] == 3) {
                                $priorityClass = 'bg-red-100 text-red-800'; // Negative feedback
                                $priorityText = 'Negative';
                            } else {
                                $priorityClass = 'bg-gray-100 text-gray-800';
                                $priorityText = 'Unknown';
                            }
                            ?>
                            <div class="bg-white border rounded-lg shadow-sm p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="font-medium text-gray-900"><?= esc($item['type']) ?></div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                        <?= $priorityText ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-3">
                                    <?= strlen($item['description']) > 100 ? esc(substr($item['description'], 0, 100) . '...') : esc($item['description']) ?>
                                </p>
                                <div class="text-xs text-gray-500 mb-3">
                                    <?= date('M d, Y', strtotime($item['created_at'])) ?>
                                </div>
                                <div class="flex justify-between pt-2 border-t border-gray-100">
                                    <button data-feedback-id="<?= $item['id'] ?>" class="text-blue-600 hover:text-blue-900 open-modal flex items-center transition duration-300 ease-in-out text-sm">
                                        <span class="material-icons mr-1" style="font-size:16px;">visibility</span>
                                        View
                                    </button>
                                    <a href="<?= base_url('User/feedbacks/edit/'.$item['id']) ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center transition duration-300 ease-in-out text-sm">
                                        <span class="material-icons mr-1" style="font-size:16px;">edit</span>
                                        Edit
                                    </a>
                                    <a href="<?= base_url('User/feedbacks/delete/'.$item['id']) ?>" onclick="return confirm('Are you sure you want to delete this feedback?')" class="text-red-600 hover:text-red-900 flex items-center transition duration-300 ease-in-out text-sm">
                                        <span class="material-icons mr-1" style="font-size:16px;">delete</span>
                                        Delete
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="text-center py-6 text-gray-500">You haven't submitted any feedback yet</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Modals Container -->
<?php if (!empty($feedback)): ?>
    <?php foreach ($feedback as $item): ?>
        <?php
        // Determine priority based on level
        $priorityClass = '';
        $priorityText = '';
        
        if ($item['level'] == 1) {
            $priorityClass = 'bg-green-100 text-green-800'; // Positive feedback
            $priorityText = 'Positive';
        } elseif ($item['level'] == 2) {
            $priorityClass = 'bg-yellow-100 text-yellow-800'; // Neutral feedback
            $priorityText = 'Neutral';
        } elseif ($item['level'] == 3) {
            $priorityClass = 'bg-red-100 text-red-800'; // Negative feedback
            $priorityText = 'Negative';
        } else {
            $priorityClass = 'bg-gray-100 text-gray-800';
            $priorityText = 'Unknown';
        }
        ?>
        <!-- Modal for each feedback -->
        <div id="modal-<?= $item['id'] ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
            <div class="flex items-center justify-center min-h-screen px-4">
                <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content mx-2">
                    
                    <!-- Content -->
                    <div class="p-4 sm:p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Feedback Details</h3>
                            <button class="text-gray-400 hover:text-gray-500 close-modal" data-feedback-id="<?= $item['id'] ?>">
                                <span class="material-icons">close</span>
                            </button>
                        </div>
                        
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Feedback Information</h4>
                            <div class="space-y-3 sm:space-y-4">
                                <div class="flex flex-col sm:flex-row sm:items-center">
                                    <span class="text-gray-600 font-medium sm:w-24 mb-1 sm:mb-0">Type:</span>
                                    <span class="text-gray-800"><?= esc($item['type']) ?></span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center">
                                    <span class="text-gray-600 font-medium sm:w-24 mb-1 sm:mb-0">Priority:</span>
                                    <span class="px-2 inline-flex text-s leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                        <?= $priorityText ?>
                                    </span>
                                </div>
                                <div class="flex flex-col sm:flex-row sm:items-center">
                                    <span class="text-gray-600 font-medium sm:w-24 mb-1 sm:mb-0">Created:</span>
                                    <span class="text-gray-800"><?= date('M d, Y h:i A', strtotime($item['created_at'])) ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg mb-4 sm:mb-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Description</h4>
                            <div class="text-gray-800 whitespace-pre-wrap"><?= esc($item['description']) ?></div>
                        </div>
                        
                        <!-- Action Section -->
                        <div class="mt-4 sm:mt-6 border-t pt-4 flex flex-col sm:flex-row sm:justify-between gap-3">
                            <a href="<?= base_url('User/feedbacks/edit/'.$item['id']) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center justify-center transition duration-300 ease-in-out">
                                <span class="material-icons mr-1" style="font-size: 18px;">edit</span>
                                Edit Feedback
                            </a>
                            <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center justify-center transition duration-300 ease-in-out close-modal" data-feedback-id="<?= $item['id'] ?>">
                                <span class="material-icons mr-1" style="font-size: 18px;">close</span>
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<script>
    // Open modal function with animation
    document.querySelectorAll('.open-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.getAttribute('data-feedback-id');
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
            const id = btn.getAttribute('data-feedback-id');
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