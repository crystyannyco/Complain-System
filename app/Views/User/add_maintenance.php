<style>
    select[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
        pointer-events: none;
    }
    input[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }
</style>
<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- Add Maintenance Form Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add Maintenance Request</h2>
                    <a href="<?= base_url('User/maintenance') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Maintenance
                    </a>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php if (is_array(session()->getFlashdata('errors'))): ?>
                            <ul class="list-disc pl-5">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <?= session()->getFlashdata('errors') ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('User/maintenance/add') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User ID (Hidden) -->
                        <div class="mb-4 hidden">
                            <label for="resident_id" class="block text-gray-700 font-medium mb-2">User ID</label>
                            <input type="hidden" id="resident_id" name="resident_id" 
                                value="<?= $user_id ?? old('resident_id') ?>">
                        </div>

                        <!-- Resident Information (read-only) -->
                        <div class="mb-4 hidden">
                            <label class="block text-gray-700 font-medium mb-2">Resident</label>
                            <input type="text" value="<?= esc($currentUser['full_name'] ?? 'Current User') ?>" readonly
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Room Information (read-only) -->
                        <div class="mb-4 hidden">
                            <label class="block text-gray-700 font-medium mb-2">Room</label>
                            <input type="text" value="<?= !empty($userRoom) ? 'Room ' . esc($userRoom['room_number']) . (!empty($userRoom['bed_name']) ? ', Bed ' . esc($userRoom['bed_name']) : '') : 'Not Assigned' ?>" readonly
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <input type="hidden" name="room_id" value="<?= !empty($userRoom) ? $userRoom['room_id'] : '' ?>">
                        </div>

                        <!-- Issue Type Selection -->
                        <div class="mb-4">
                            <label for="issue_type" class="block text-gray-700 font-medium mb-2">Issue Type *</label>
                            <select id="issue_type" name="issue_type" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.issue_type') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Issue Type --</option>
                                <?php foreach ($issueTypes as $id => $type): ?>
                                    <option value="<?= $id ?>" <?= old('issue_type') == $id ? 'selected' : '' ?>>
                                        <?= esc($type) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.issue_type')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.issue_type') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Priority Selection -->
                        <div class="mb-4">
                            <label for="priority" class="block text-gray-700 font-medium mb-2">Priority *</label>
                            <select id="priority" name="priority" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.priority') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Priority --</option>
                                <?php foreach ($priorityLabels as $id => $priority): ?>
                                    <option value="<?= $id ?>" <?= old('priority') == $id ? 'selected' : '' ?>>
                                        <?= esc($priority) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.priority')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.priority') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.description') ? 'border-red-500' : '' ?>"><?= old('description') ?></textarea>
                            <?php if (session()->getFlashdata('errors.description')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.description') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center">
                            <span class="material-icons mr-2">save</span>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>                       
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const residentDropdown = document.getElementById('resident_id');
        const roomDropdown = document.getElementById('room_id');
        
        // Function to update room selection based on resident
        // Replace this in your JavaScript section
        function updateRoomSelection() {
            const selectedOption = residentDropdown.options[residentDropdown.selectedIndex];
            const roomId = selectedOption.getAttribute('data-room-id');
            
            if (roomId) {
                // Find and select the corresponding room option
                for (let i = 0; i < roomDropdown.options.length; i++) {
                    if (roomDropdown.options[i].value === roomId) {
                        roomDropdown.selectedIndex = i;
                        break;
                    }
                }
            }
        }
        
        // Add event listener for resident dropdown change
        residentDropdown.addEventListener('change', updateRoomSelection);
        
        // Run once on page load to set initial value
        if (residentDropdown.value) {
            updateRoomSelection();
        }
    });
</script>