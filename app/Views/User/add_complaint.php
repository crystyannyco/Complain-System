<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <!-- Add Complaint Form Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add Complaint</h2>
                    <a href="<?= base_url('User/complaints') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Complaints
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

                <form action="<?= base_url('User/complaints/add') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4 hidden">
                            <label for="resident_id" class="block text-gray-700 font-medium mb-2">Resident ID *</label>
                            <input type="text" id="resident_id" name="resident_id" 
                                value="<?= session()->get('id') ?>" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.resident_id') ? 'border-red-500' : '' ?>">
                            <?php if (session()->getFlashdata('errors.resident_id')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.resident_id') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="type" class="block text-gray-700 font-medium mb-2">Complaint Type *</label>
                            <select id="type" name="type" 
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.type') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Complaint --</option>
                                <optgroup label="Level 1 - Low Priority">
                                    <option value="1" <?= old('type') == '1' ? 'selected' : '' ?>>Trash bins left uncollected for a day</option>
                                    <option value="2" <?= old('type') == '2' ? 'selected' : '' ?>>Someone using personal belongings without asking</option>
                                    <option value="3" <?= old('type') == '3' ? 'selected' : '' ?>>Late response from admin or staff</option>
                                    <option value="4" <?= old('type') == '4' ? 'selected' : '' ?>>Wet floors in shared bathroom</option>
                                    <option value="5" <?= old('type') == '5' ? 'selected' : '' ?>>Room smells musty after cleaning</option>
                                    <option value="6" <?= old('type') == '6' ? 'selected' : '' ?>>Complaint about worn-out posters or signs</option>
                                    <option value="7" <?= old('type') == '7' ? 'selected' : '' ?>>Incomplete cleaning of common kitchen</option>
                                    <option value="8" <?= old('type') == '8' ? 'selected' : '' ?>>Light scolding from staff perceived as rude</option>
                                </optgroup>
                                <optgroup label="Level 2 - Medium Priority">
                                    <option value="9" <?= old('type') == '9' ? 'selected' : '' ?>>Constant noise from neighbors or loud music at night</option>
                                    <option value="10" <?= old('type') == '10' ? 'selected' : '' ?>>Dirty common areas even after repeated reminders</option>
                                    <option value="11" <?= old('type') == '11' ? 'selected' : '' ?>>Frequent visitors violating house rules</option>
                                    <option value="12" <?= old('type') == '12' ? 'selected' : '' ?>>Roommate consistently disorganized or messy</option>
                                    <option value="13" <?= old('type') == '13' ? 'selected' : '' ?>>Disrespectful roommate behavior</option>
                                    <option value="14" <?= old('type') == '14' ? 'selected' : '' ?>>Unauthorized minor guest entering the premises</option>
                                    <option value="15" <?= old('type') == '15' ? 'selected' : '' ?>>Uncollected garbage attracting insects</option>
                                </optgroup>
                                <optgroup label="Level 3 - High Priority">
                                    <option value="16" <?= old('type') == '16' ? 'selected' : '' ?>>Theft or missing personal belongings</option>
                                    <option value="17" <?= old('type') == '17' ? 'selected' : '' ?>>Physical or verbal harassment</option>
                                    <option value="18" <?= old('type') == '18' ? 'selected' : '' ?>>Unauthorized trespassing or loitering</option>
                                    <option value="19" <?= old('type') == '19' ? 'selected' : '' ?>>Threats or fights between tenants</option>
                                    <option value="20" <?= old('type') == '20' ? 'selected' : '' ?>>Roommate invasion of privacy</option>
                                    <option value="21" <?= old('type') == '21' ? 'selected' : '' ?>>Reports of alcohol, drugs, or weapon possession</option>
                                    <option value="22" <?= old('type') == '22' ? 'selected' : '' ?>>Bullying or discrimination (race, gender, religion, etc.)</option>
                                    <option value="23" <?= old('type') == '23' ? 'selected' : '' ?>>Resident violating curfew with aggressive behavior</option>
                                    <option value="24" <?= old('type') == '24' ? 'selected' : '' ?>>Fire or emergency exit blocked by belongings</option>
                                    <option value="25" <?= old('type') == '25' ? 'selected' : '' ?>>Serious privacy invasion (recording someone, breaking into room)</option>
                                </optgroup>
                            </select>
                            <?php if (session()->getFlashdata('errors.type')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.type') ?></p>
                            <?php endif; ?>
                        </div>

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
                            <span class="material-icons mr-2">send</span>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>                       
    </main>
</div>