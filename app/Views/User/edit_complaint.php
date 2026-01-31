<style>
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
                    <a href="<?= base_url('User/complaints') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
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

                <form action="<?= base_url('User/complaints/update/' . $complaint['complaint_id']) ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- <div class="mb-4">
                            <label for="resident_id" class="block text-gray-700 font-medium mb-2">Resident ID *</label>
                            <input type="text" id="resident_id" name="resident_id" 
                                value="<?= old('resident_id', $complaint['resident_id']) ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.resident_id') ? 'border-red-500' : '' ?>">
                            <?php if (session()->getFlashdata('errors.resident_id')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.resident_id') ?></p>
                            <?php endif; ?>
                        </div> -->

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="type" class="block text-gray-700 font-medium mb-2">Complaint Type *</label>
                            <select id="type" name="type" 
                                class="readonly w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.type') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Complaint --</option>
                                <optgroup label="Level 1 - Low Priority">
                                    <option value="1" <?= old('type', $complaint['type']) == '1' ? 'selected' : '' ?>>Trash bins left uncollected for a day</option>
                                    <option value="2" <?= old('type', $complaint['type']) == '2' ? 'selected' : '' ?>>Someone using personal belongings without asking</option>
                                    <option value="3" <?= old('type', $complaint['type']) == '3' ? 'selected' : '' ?>>Late response from admin or staff</option>
                                    <option value="4" <?= old('type', $complaint['type']) == '4' ? 'selected' : '' ?>>Wet floors in shared bathroom</option>
                                    <option value="5" <?= old('type', $complaint['type']) == '5' ? 'selected' : '' ?>>Room smells musty after cleaning</option>
                                    <option value="6" <?= old('type', $complaint['type']) == '6' ? 'selected' : '' ?>>Complaint about worn-out posters or signs</option>
                                    <option value="7" <?= old('type', $complaint['type']) == '7' ? 'selected' : '' ?>>Incomplete cleaning of common kitchen</option>
                                    <option value="8" <?= old('type', $complaint['type']) == '8' ? 'selected' : '' ?>>Light scolding from staff perceived as rude</option>
                                </optgroup>
                                <optgroup label="Level 2 - Medium Priority">
                                    <option value="9" <?= old('type', $complaint['type']) == '9' ? 'selected' : '' ?>>Constant noise from neighbors or loud music at night</option>
                                    <option value="10" <?= old('type', $complaint['type']) == '10' ? 'selected' : '' ?>>Dirty common areas even after repeated reminders</option>
                                    <option value="11" <?= old('type', $complaint['type']) == '11' ? 'selected' : '' ?>>Frequent visitors violating house rules</option>
                                    <option value="12" <?= old('type', $complaint['type']) == '12' ? 'selected' : '' ?>>Roommate consistently disorganized or messy</option>
                                    <option value="13" <?= old('type', $complaint['type']) == '13' ? 'selected' : '' ?>>Disrespectful roommate behavior</option>
                                    <option value="14" <?= old('type', $complaint['type']) == '14' ? 'selected' : '' ?>>Unauthorized minor guest entering the premises</option>
                                    <option value="15" <?= old('type', $complaint['type']) == '15' ? 'selected' : '' ?>>Uncollected garbage attracting insects</option>
                                </optgroup>
                                <optgroup label="Level 3 - High Priority">
                                    <option value="16" <?= old('type', $complaint['type']) == '16' ? 'selected' : '' ?>>Theft or missing personal belongings</option>
                                    <option value="17" <?= old('type', $complaint['type']) == '17' ? 'selected' : '' ?>>Physical or verbal harassment</option>
                                    <option value="18" <?= old('type', $complaint['type']) == '18' ? 'selected' : '' ?>>Unauthorized trespassing or loitering</option>
                                    <option value="19" <?= old('type', $complaint['type']) == '19' ? 'selected' : '' ?>>Threats or fights between tenants</option>
                                    <option value="20" <?= old('type', $complaint['type']) == '20' ? 'selected' : '' ?>>Roommate invasion of privacy</option>
                                    <option value="21" <?= old('type', $complaint['type']) == '21' ? 'selected' : '' ?>>Reports of alcohol, drugs, or weapon possession</option>
                                    <option value="22" <?= old('type', $complaint['type']) == '22' ? 'selected' : '' ?>>Bullying or discrimination (race, gender, religion, etc.)</option>
                                    <option value="23" <?= old('type', $complaint['type']) == '23' ? 'selected' : '' ?>>Resident violating curfew with aggressive behavior</option>
                                    <option value="24" <?= old('type', $complaint['type']) == '24' ? 'selected' : '' ?>>Fire or emergency exit blocked by belongings</option>
                                    <option value="25" <?= old('type', $complaint['type']) == '25' ? 'selected' : '' ?>>Serious privacy invasion (recording someone, breaking into room)</option>
                                </optgroup>
                            </select>
                            <?php if (session()->getFlashdata('errors.type')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.type') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.description') ? 'border-red-500' : '' ?>"><?= old('description', $complaint['description']) ?></textarea>
                            <?php if (session()->getFlashdata('errors.description')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.description') ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="status" class="block text-gray-700 font-medium mb-2">Status *</label>
                            <select id="status" name="status" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.status') ? 'border-red-500' : '' ?>">
                                <option value="0" <?= old('status', $complaint['status']) == 'Pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="1" <?= old('status', $complaint['status']) == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="2" <?= old('status', $complaint['status']) == 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                                <option value="3" <?= old('status', $complaint['status']) == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                            </select>
                            <?php if (session()->getFlashdata('errors.status')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.status') ?></p>
                            <?php endif; ?>
                        </div> -->
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
