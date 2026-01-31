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
        
            <!-- Feedback List -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Feedback</h2>
                    <!-- <a href="<?= base_url('feedbacks/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">add</span>
                        Add Feedback
                    </a> -->
                </div>
                
                <!-- Feedback Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fullname</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($feedback)): ?>
                                <?php foreach ($feedback as $item): ?>
                                    <?php
                                    // Determine priority based on id
                                    $priorityClass = '';
                                    $priorityText = '';
                                    
                                    if (isset($item['feedback_type'])) {
                                        if ($item['feedback_type'] >= 1 && $item['feedback_type'] <= 6) {
                                            $priorityClass = 'bg-green-100 text-green-800'; // Positive feedback - Low priority
                                            $priorityText = 'Positive';
                                        } elseif ($item['feedback_type'] >= 7 && $item['feedback_type'] <= 10) {
                                            $priorityClass = 'bg-yellow-100 text-yellow-800'; // Neutral feedback - Medium priority
                                            $priorityText = 'Neutral';
                                        } elseif ($item['feedback_type'] >= 11 && $item['feedback_type'] <= 14) {
                                            $priorityClass = 'bg-red-100 text-red-800'; // Negative feedback - High priority
                                            $priorityText = 'Negative';
                                        } else {
                                            $priorityClass = 'bg-gray-100 text-gray-800';
                                            $priorityText = 'Unknown';
                                        }
                                    }                                    

                                    // Determine feedback ID for references
                                    $feedbackId = $item['id'] ?? $item['id'];
                                    ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($item['resident_name']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($item['type']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($item['description']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                <?= $priorityText ?>
                                            </span>
                                        </td>
                                        <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button data-feedback-id="<?= $feedbackId ?>" class="text-blue-600 hover:text-blue-900 mr-3 open-modal transition duration-300 ease-in-out flex items-center">
                                                <span class="mr-1 material-icons">visibility</span>
                                                View
                                            </button>
                                            <!-- <a href="<?= base_url('feedbacks/edit/'.$feedbackId) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-300 ease-in-out flex items-center inline-flex">
                                                <span class="mr-1 material-icons">edit</span>
                                                Edit
                                            </a> -->
                                            <a href="<?= base_url('feedbacks/delete/'.$feedbackId) ?>" class="text-red-600 hover:text-red-900 transition duration-300 ease-in-out flex items-center inline-flex" onclick="return confirm('Are you sure you want to delete this feedback?')">
                                                <span class="mr-1 material-icons">delete</span>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal for each feedback - Improved user-friendly version -->
                                    <div id="modal-<?= $feedbackId ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                                        <div class="flex items-center justify-center min-h-screen px-4">
                                            <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content">
                                                
                                                <!-- Content -->
                                                <div class="p-6">
                                                    <div class="grid grid-cols-1 md:grid-cols-1 gap-4 mb-6">
                                                        <div class="bg-gray-50 p-4 rounded-lg">
                                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">User Information</h4>
                                                            <div class="space-y-4 mb-4">
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">User ID:</span>
                                                                    <span class="text-gray-800"><?= esc($item['user_id']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Fullname:</span>
                                                                    <span class="text-gray-800"><?= esc($item['resident_name']) ?></span>
                                                                </div>
                                                            </div>
                                                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Feedback Information</h4>
                                                            <div class="space-y-4">
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Type:</span>
                                                                    <span class="text-gray-800"><?= esc($item['type']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Priority:</span>
                                                                    <span class="px-2 inline-flex text-s leading-5 font-semibold rounded-full <?= $priorityClass ?>">
                                                                        <?= $priorityText ?>
                                                                    </span>
                                                                </div>
                                                                <?php if(isset($item['created_at'])): ?>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Created:</span>
                                                                    <span class="text-gray-800"><?= esc($item['created_at']) ?></span>
                                                                </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                                        <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Description</h4>
                                                        <div class="text-gray-800 whitespace-pre-wrap"><?= esc($item['description']) ?></div>
                                                    </div>
                                                    
                                                    <!-- Action Section -->
                                                    <div class="mt-6 border-t pt-4 flex justify-between">
                                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center transition duration-300 ease-in-out close-modal" data-feedback-id="<?= $feedbackId ?>">
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
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No feedback found</td>
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