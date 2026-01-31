<style>
    select[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
        pointer-events: none;
    }
    .readonly {
        background-color: #f1f5f9;  /* Light gray background to indicate non-interactive */
        color: #6b7280;  /* Gray text to match the readonly style */
        border: 1px solid #d1d5db;  /* Light border color */
        pointer-events: none;  /* Disable mouse interaction */
        cursor: not-allowed;  /* Change cursor to indicate no interaction */
    }
</style>
<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- Edit Maintenance Form Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Maintenance Request</h2>
                    <a href="<?= base_url('maintenance') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
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

                <form action="<?= base_url('maintenance/update/' . $maintenance['maintenance_id']) ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Resident Selection -->
                        <div class="mb-2">
                            <label for="resident_id" class="block text-gray-700 font-medium mb-2">Resident *</label>
                            <select id="resident_id" name="resident_id" readonly
                                class="w-full px-4 py-2 readonly border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.resident_id') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Resident --</option>
                                <?php foreach ($tenants as $tenant): ?>
                                    <option value="<?= $tenant['id'] ?>" 
                                            data-room-id="<?= $tenant['room_id'] ?? '' ?>"
                                            <?= (old('resident_id', $maintenance['resident_id']) == $tenant['id']) ? 'selected' : '' ?>>
                                        <?= esc($tenant['full_name']) ?>
                                        <?= !empty($tenant['room_number']) ? ' (Room ' . esc($tenant['room_number']) . ')' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.resident_id')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.resident_id') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Room Selection -->
                        <div class="mb-2">
                            <label for="room_id" class="block text-gray-700 font-medium mb-2">Room *</label>
                            <select id="room_id" name="room_id" readonly
                                class="w-full px-4 py-2 readonly border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.room_id') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Room --</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?= $room['room_id'] ?>" 
                                            <?= (old('room_id', $maintenance['room_id']) == $room['room_id']) ? 'selected' : '' ?>>
                                        Room <?= esc($room['room_number']) ?>
                                        <?= !empty($room['bed_name']) ? ' (' . esc($room['bed_name']) . ')' : '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.room_id')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.room_id') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Issue Type Selection -->
                        <div class="mb-2">
                            <label for="issue_type" class="block text-gray-700 font-medium mb-2">Issue Type *</label>
                            <select id="issue_type" name="issue_type" 
                                class="w-full px-4 readonly py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.issue_type') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Issue Type --</option>
                                <?php foreach ($issueTypes as $id => $type): ?>
                                    <option value="<?= $id ?>" <?= (old('issue_type', $maintenance['issue_type']) == $id) ? 'selected' : '' ?>>
                                        <?= esc($type) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.issue_type')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.issue_type') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Priority Selection -->
                        <div class="mb-2">
                            <label for="priority" class="block text-gray-700 font-medium mb-2">Priority *</label>
                            <select id="priority" name="priority" 
                                class="w-full px-4 py-2 readonly border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.priority') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Priority --</option>
                                <?php foreach ($priorityLabels as $id => $priority): ?>
                                    <option value="<?= $id ?>" <?= (old('priority', $maintenance['priority']) == $id) ? 'selected' : '' ?>>
                                        <?= esc($priority) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session()->getFlashdata('errors.priority')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.priority') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-2 col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full readonly px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.description') ? 'border-red-500' : '' ?>"><?= old('description', $maintenance['description']) ?></textarea>
                            <?php if (session()->getFlashdata('errors.description')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.description') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- Read-only Information -->
                        <div class="mb-4 col-span-1">
                            <label class="block text-gray-700 font-medium mb-2">Reported Date</label>
                            <div class="px-4 py-2 border rounded-md bg-gray-100 readonly">
                                <?= date('M d, Y g:i A', strtotime($maintenance['reported_date'])) ?>
                            </div>
                        </div>

                        <?php if (!empty($maintenance['resolved_date'])): ?>
                        <div class="mb-4 col-span-1">
                            <label class="block text-gray-700 font-medium mb-2">Resolved Date</label>
                            <div class="px-4 py-2 border rounded-md bg-gray-100 readonly">
                                <?= date('M d, Y g:i A', strtotime($maintenance['resolved_date'])) ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Status Selection (Only in Edit form) -->
                    <div class="mb-2">
                        <label for="status" class="block text-gray-700 font-medium mb-2">Status *</label>
                        <select id="status" name="status" 
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.status') ? 'border-red-500' : '' ?>">
                            <?php foreach ($statusLabels as $id => $status): ?>
                                <option value="<?= $id ?>" <?= (old('status', $maintenance['status']) == $id) ? 'selected' : '' ?>>
                                    <?= esc($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errors.status')): ?>
                            <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.status') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mt-6 flex justify-end space-x-4">
                        <!-- Delete button -->
                        <a href="<?= base_url('maintenance/delete/' . $maintenance['maintenance_id']) ?>" 
                           onclick="return confirm('Are you sure you want to delete this maintenance request?');"
                           class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-md flex items-center">
                            <span class="material-icons mr-2">delete</span>
                            Delete
                        </a>
                        
                        <!-- Update button -->
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center">
                            <span class="material-icons mr-2">save</span>
                            Update Request
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