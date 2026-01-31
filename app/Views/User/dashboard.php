

        <!-- Dashboard Content -->
        <div class="flex-1 p-6">
            <!-- Quick Actions -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Submit Complaint/Feedback -->
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="mb-4 text-blue-600">
                            <span class="material-icons text-4xl">assignment</span>
                        </div>
                        <h4 class="text-lg font-semibold mb-2">Report Complaint</h4>
                        <p class="text-gray-600 mb-4">Report issues about our services.</p>
                        <a href="<?= base_url('User/complaints') ?>" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</a>
                    </div>

                    <!-- View Room/Bed -->
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="mb-4 text-orange-500">
                            <span class="material-icons text-4xl">warning</span>
                        </div>
                        <h4 class="text-lg font-semibold mb-2">View Feedback</h4>
                        <p class="text-gray-600 mb-4">Submit feedback about our services.</p>
                        <a href="<?= base_url('User/feedbacks') ?>" class="inline-block px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700">Submit</a>
                    </div>

                    <!-- Request Maintenance -->
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="mb-4 text-red-600">
                            <span class="material-icons text-4xl">build</span>
                        </div>
                        <h4 class="text-lg font-semibold mb-2">Request Maintenance</h4>
                        <p class="text-gray-600 mb-4">Request repairs or maintenance for your room.</p>
                        <a href="<?= base_url('User/maintenance') ?>" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Request</a>
                    </div>

                    <!-- Notifications -->
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        <div class="mb-4 text-yellow-600">
                            <span class="material-icons text-4xl">notifications</span>
                        </div>
                        <h4 class="text-lg font-semibold mb-2">Notifications</h4>
                        <p class="text-gray-600 mb-4">Check your latest notifications and announcements.</p>
                        <a href="<?= base_url('User/announcements') ?>" class="inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">View</a>
                    </div>
                </div>
            </div>

            <!-- Recent Announcements -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="border-b px-6 py-3">
                    <h3 class="text-lg font-semibold">Recent Announcements</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        
                        <?php if (isset($announcements) && !empty($announcements)): ?>
                            <a href="<?= base_url('User/announcements') ?>">
                            <?php foreach ($announcements as $announcement): ?>
                                <div class="border rounded-lg mb-2">
                                    <button class="flex justify-between items-center w-full px-4 py-3 text-left font-semibold">
                                        <?= esc($announcement['title']) ?> - <?= date('M d, Y', strtotime($announcement['created_at'])) ?>
                                        <span class="material-icons">expand_more</span>
                                    </button>
                                    <div class="px-4 py-3 border-t">
                                        <p><?= esc($announcement['content']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?></a>
                        <?php else: ?>
                            <p>No announcements available.</p>
                        <?php endif; ?>
                    </div>

                    <div class="text-right">
                        <a href="<?= base_url('User/announcements') ?>" class="inline-block px-4 py-2 border border-blue-600 text-blue-600 rounded hover:bg-blue-50">View All Announcements</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar functionality
        document.getElementById('openSidebar').addEventListener('click', function() {
            document.getElementById('mobileSidebar').classList.add('active');
            document.querySelector('.mobile-sidebar').classList.add('active');
        });

        document.getElementById('closeSidebar').addEventListener('click', function() {
            document.getElementById('mobileSidebar').classList.remove('active');
            document.querySelector('.mobile-sidebar').classList.remove('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('mobileSidebar').classList.remove('active');
            document.querySelector('.mobile-sidebar').classList.remove('active');
        });
    </script>
</body>
</html>