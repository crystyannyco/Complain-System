<!-- Announcements List Container -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Announcements Management</h2>
                    <a href="<?= base_url('announcements/add') ?>" data-toggle="modal" data-target="#addAnnouncementModal" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">add</span>
                        Add New Announcement
                    </a>
                </div>

                <!-- Display validation errors -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Display success message -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Announcement Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (isset($announcements) && is_array($announcements)): ?>
                                <?php foreach ($announcements as $announcement): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($announcement['id']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($announcement['title']) ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= esc($announcement['created_at']) ?></td>
                                        <td class="flex px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button data-announcement-id="<?= esc($announcement['id']) ?>" class="text-blue-600 hover:text-blue-900 mr-3 open-modal transition duration-300 ease-in-out flex items-center">
                                                <span class="mr-1 material-icons">visibility</span>
                                                View
                                            </button>
                                            <a href="<?= base_url('announcements/edit/'.esc($announcement['id'])) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-300 ease-in-out flex items-center inline-flex">
                                                <span class="mr-1 material-icons">edit</span>
                                                Edit
                                            </a>
                                            <a href="<?= base_url('announcements/delete/'.esc($announcement['id'])) ?>" class="text-red-600 hover:text-red-900 transition duration-300 ease-in-out flex items-center inline-flex" onclick="return confirm('Are you sure you want to delete this announcement?')">
                                                <span class="mr-1 material-icons">delete</span>
                                                Delete
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Modal for each announcement -->
                                    <div id="modal-<?= esc($announcement['id']) ?>" class="fixed inset-0 z-50 hidden overflow-y-auto bg-gray-800 bg-opacity-75 transition-opacity duration-300">
                                        <div class="flex items-center justify-center min-h-screen px-4">
                                            <div class="bg-white w-full max-w-lg rounded-lg shadow-xl relative transform transition-all scale-95 opacity-0 modal-content">
                                                <!-- Content -->
                                                <div class="p-6">
                                                    <div class="grid grid-cols-1 gap-4 mb-6">
                                                        <div class="bg-gray-50 p-4 rounded-lg">
                                                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Announcement Information</h4>
                                                            <div class="space-y-4 mb-4">
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">ID:</span>
                                                                    <span class="text-gray-800"><?= esc($announcement['id']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Title:</span>
                                                                    <span class="text-gray-800"><?= esc($announcement['title']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Content:</span>
                                                                    <span class="text-gray-800"><?= esc($announcement['content']) ?></span>
                                                                </div>
                                                                <div class="flex items-center">
                                                                    <span class="text-gray-600 font-medium w-24">Date Created:</span>
                                                                    <span class="text-gray-800"><?= esc($announcement['created_at']) ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Action Section -->
                                                    <div class="mt-6 border-t pt-4 flex justify-between">
                                                        <a href="<?= base_url('announcements/edit/'.esc($announcement['id'])) ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md flex items-center transition duration-300 ease-in-out">
                                                            <span class="material-icons mr-2">edit</span>
                                                            Edit Announcement
                                                        </a>
                                                        <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center transition duration-300 ease-in-out close-modal" data-announcement-id="<?= esc($announcement['id']) ?>">
                                                            <span class="material-icons mr-2">close</span>
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
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">No announcements found</td>
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
