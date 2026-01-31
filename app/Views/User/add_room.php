
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-y-auto">
                <div class="py-6 px-4 sm:px-6 lg:px-8">
                    <!-- Add Room Form Container -->
                    <div class="bg-white rounded-lg shadow-lg p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Add New Room & Bed</h2>
                            <a href="<?= base_url('rooms') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                                <span class="material-icons mr-1">arrow_back</span>
                                Back to Rooms
                            </a>
                        </div>
                        
                        <!-- Display validation errors -->
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <?php if (is_array(session()->getFlashdata('errors'))): ?>
                                    <ul class="list-disc pl-5">
                                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                                            <li><?= $error ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php else: ?>
                                    <?= session()->getFlashdata('errors') ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Display success message -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                <?= session()->getFlashdata('success') ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('rooms/add') ?>" method="post">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <label for="room_number" class="block text-gray-700 font-medium mb-2">Room Number *</label>
                                    <input type="text" id="room_number" name="room_number" 
                                        value="<?= old('room_number') ?>"
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= (session()->getFlashdata('errors.room_number')) ? 'border-red-500' : '' ?>">
                                    <?php if (session()->getFlashdata('errors.room_number')): ?>
                                        <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.room_number') ?></p>
                                    <?php else: ?>
                                        <p class="text-xs text-gray-500 mt-1">Enter the room number (numeric only)</p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="capacity" class="block text-gray-700 font-medium mb-2">Capacity *</label>
                                    <input type="number" id="capacity" name="capacity" min="1" 
                                        value="<?= old('capacity') ?>"
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= (session()->getFlashdata('errors.capacity')) ? 'border-red-500' : '' ?>">
                                    <?php if (session()->getFlashdata('errors.capacity')): ?>
                                        <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.capacity') ?></p>
                                    <?php else: ?>
                                        <p class="text-xs text-gray-500 mt-1">Maximum number of occupants</p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="bed_name" class="block text-gray-700 font-medium mb-2">Bed Number/Letter *</label>
                                    <input type="text" id="bed_name" name="bed_name" 
                                        value="<?= old('bed_name') ?>"
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= (session()->getFlashdata('errors.bed_name')) ? 'border-red-500' : '' ?>">
                                    <?php if (session()->getFlashdata('errors.bed_name')): ?>
                                        <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.bed_name') ?></p>
                                    <?php else: ?>
                                        <p class="text-xs text-gray-500 mt-1">Identifier for the bed (e.g., A, B, 1, 2)</p>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="status" class="block text-gray-700 font-medium mb-2">Status *</label>
                                    <select id="status" name="status" 
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= (session()->getFlashdata('errors.status')) ? 'border-red-500' : '' ?>">
                                        <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Available</option>
                                        <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Occupied</option>
                                        <option value="2" <?= old('status') == '2' ? 'selected' : '' ?>>Reserved</option>
                                        <option value="3" <?= old('status') == '3' ? 'selected' : '' ?>>Maintenance</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.status')): ?>
                                        <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.status') ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <hr>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">

                                <!-- New tenant dropdown field -->
                                <div class="mb-4">
                                    <label for="tenant_id" class="block text-gray-700 font-medium mb-2">Tenant (Optional)</label>
                                    <select id="tenant_id" name="tenant_id" 
                                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <option value="">Select Tenant</option>
                                        <?php if (isset($tenants) && is_array($tenants)): ?>
                                            <?php foreach ($tenants as $tenant): ?>
                                                <option value="<?= $tenant['id'] ?>" <?= old('tenant_id') == $tenant['id'] ? 'selected' : '' ?>>
                                                    <?= esc($tenant['full_name']) ?> (<?= esc($tenant['username']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Select tenant if room is occupied or reserved</p>
                                </div>

                                <div class="flex flex-col md:flex-row gap-6 mb-4">
                                    <!-- Move-in Date -->
                                    <div class="w-full md:w-1/2">
                                        <label for="move_in" class="block text-gray-700 font-medium mb-2">Move-in Date (Optional)</label>
                                        <input type="date" id="move_in" name="move_in" 
                                            value="<?= old('move_in') ?>"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Date when tenant moved or will move in</p>
                                    </div>

                                    <!-- Move-out Date -->
                                    <div class="w-full md:w-1/2">
                                        <label for="move_out" class="block text-gray-700 font-medium mb-2">Move-out Date (Optional)</label>
                                        <input type="date" id="move_out" name="move_out" 
                                            value="<?= old('move_out') ?>"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Expected date when tenant will move out</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center">
                                    <span class="material-icons mr-2">add</span>
                                    Add Room
                                </button>
                            </div>
                        </form>
                    </div>
                </div>                       
            </main>
        </div>
    </div>

    <!-- JavaScript for mobile sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileSidebar = document.getElementById('mobileSidebar');
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            // Initially hide the mobile sidebar
            mobileSidebar.style.display = 'none';
            
            // Open sidebar
            openSidebarBtn.addEventListener('click', function() {
                mobileSidebar.style.display = 'block';
                setTimeout(() => {
                    mobileSidebar.querySelector('.mobile-sidebar').classList.add('active');
                }, 10);
            });
            
            // Close sidebar function
            function closeSidebar() {
                mobileSidebar.querySelector('.mobile-sidebar').classList.remove('active');
                setTimeout(() => {
                    mobileSidebar.style.display = 'none';
                }, 300);
            }
            
            // Close sidebar events
            closeSidebarBtn.addEventListener('click', closeSidebar);
            sidebarOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>