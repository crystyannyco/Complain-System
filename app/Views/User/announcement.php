<!-- Announcements List Container -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-4 px-2 sm:py-6 sm:px-4 md:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-3 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-3">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Announcements Management</h2>
                    <!-- <a href="<?= base_url('User/announcements/add') ?>" data-toggle="modal" data-target="#addAnnouncementModal" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-md flex items-center justify-center sm:justify-start text-sm sm:text-base">
                        <span class="material-icons mr-1 text-sm sm:text-base">add</span>
                        Add New Announcement
                    </a> -->
                </div>

                <!-- Display validation errors -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 py-2 rounded mb-4 text-sm sm:text-base">
                        <ul class="list-disc pl-5">
                            <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Display success message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-3 py-2 rounded mb-4 text-sm sm:text-base">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Announcement Table -->
                <div class="overflow-x-auto -mx-3 sm:mx-0">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-2 py-2 sm:px-4 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-2 py-2 sm:px-4 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-2 py-2 sm:px-4 sm:py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (isset($announcements) && is_array($announcements)): ?>
                                <?php foreach ($announcements as $announcement): ?>
                                    <tr>
                                        <td class="px-2 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm md:text-base">
                                            <div class="truncate max-w-xs md:max-w-md lg:max-w-full">
                                                <?= esc($announcement['title']) ?>
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm md:text-base">
                                            <?= esc($announcement['created_at']) ?>
                                        </td>
                                        <td class="px-2 py-2 sm:px-4 sm:py-3 whitespace-nowrap text-xs sm:text-sm font-medium">
                                            <button data-announcement-id="<?= esc($announcement['id']) ?>" class="text-blue-600 hover:text-blue-900 transition duration-300 ease-in-out flex items-center open-modal">
                                                <span class="material-icons text-sm mr-1">visibility</span>
                                                View
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal for each announcement -->
                                    <div id="modal-<?= esc($announcement['id']) ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                                        <div class="flex items-center justify-center min-h-screen px-4">
                                            <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content">
                                                <!-- Content -->
                                                <div class="p-4 sm:p-6">
                                                    <div class="grid grid-cols-1 gap-4 mb-4 sm:mb-6">
                                                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                                                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Announcement Information</h4>
                                                            <div class="space-y-3 sm:space-y-4">
                                                                <div class="flex flex-col sm:flex-row sm:items-center">
                                                                    <span class="text-gray-600 font-medium w-full sm:w-24 mb-1 sm:mb-0">Title:</span>
                                                                    <span class="text-gray-800 text-sm sm:text-base"><?= esc($announcement['title']) ?></span>
                                                                </div>
                                                                <div class="flex flex-col sm:flex-row">
                                                                    <span class="text-gray-600 font-medium w-full sm:w-24 mb-1 sm:mb-0">Content:</span>
                                                                    <div class="text-gray-800 text-sm sm:text-base break-words"><?= esc($announcement['content']) ?></div>
                                                                </div>
                                                                <div class="flex flex-col sm:flex-row sm:items-center">
                                                                    <span class="text-gray-600 font-medium w-full sm:w-24 mb-1 sm:mb-0">Date Created:</span>
                                                                    <span class="text-gray-800 text-sm sm:text-base"><?= esc($announcement['created_at']) ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action Section -->
                                                    <div class="mt-4 sm:mt-6 border-t pt-4 flex justify-end">
                                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-3 py-2 rounded-md flex items-center transition duration-300 ease-in-out close-modal text-sm sm:text-base" data-announcement-id="<?= esc($announcement['id']) ?>">
                                                            <span class="material-icons mr-1 text-sm sm:text-base">close</span>
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
                                    <td colspan="3" class="px-2 py-3 sm:px-6 sm:py-4 text-center text-gray-500 text-sm sm:text-base">No announcements found</td>
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
            const id = btn.getAttribute('data-announcement-id');
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
            const id = btn.getAttribute('data-announcement-id');
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