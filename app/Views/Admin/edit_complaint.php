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
            <!-- Edit Complaint Form Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Complaint</h2>
                    <a href="<?= base_url('complaints') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Complaints
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

                <form action="<?= base_url('complaints/update/' . $complaint['complaint_id']) ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="resident_id" class="block text-gray-700 font-medium mb-2">Resident *</label>
                            <input type="text" id="resident_display" 
                                value="<?= $complaint['resident_name'] ?? 'Unknown' ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500">
                            <input type="hidden" id="resident_id" name="resident_id" 
                                value="<?= old('resident_id', $complaint['resident_id']) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="room_bed" class="block text-gray-700 font-medium mb-2">Room & Bed</label>
                            <input type="text" id="room_bed" 
                                value="<?= $complaint['room'] ?? 'Not Assigned' ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500">
                        </div>

                        <!-- Complaint Type field - Make readonly -->
                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="type" class="block text-gray-700 font-medium mb-2">Complaint Type *</label>
                            
                            <!-- Hidden input to maintain the value for form submission -->
                            <input type="hidden" name="type" value="<?= old('type', $complaint['type_id'] ?? $complaint['type']) ?>">
                            
                            <!-- Readonly text display showing the complaint type -->
                            <input type="text" 
                                value="<?= $complaint['type'] ?? $complaintTypeText ?? 'Unknown' ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500"
                                readonly>
                        </div>

                        <!-- Description field - Make readonly -->
                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                            
                            <!-- Hidden input to maintain the value for form submission -->
                            <input type="hidden" name="description" value="<?= old('description', $complaint['description']) ?>">
                            
                            <!-- Readonly textarea showing the description -->
                            <textarea rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500"
                                readonly><?= old('description', $complaint['description']) ?></textarea>
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status *</label>
                            <select id="status" name="status" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.status') ? 'border-red-500' : '' ?>">
                                <option value="0" <?= old('status', $complaint['status_id'] ?? 0) == 0 ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?= old('status', $complaint['status_id'] ?? 0) == 1 ? 'selected' : '' ?>>In Progress</option>
                                <option value="2" <?= old('status', $complaint['status_id'] ?? 0) == 2 ? 'selected' : '' ?>>Resolved</option>
                                <option value="3" <?= old('status', $complaint['status_id'] ?? 0) == 3 ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <?php if (session()->getFlashdata('errors.status')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.status') ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center">
                            <span class="material-icons mr-2">save</span>
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>                       
    </main>
</div>