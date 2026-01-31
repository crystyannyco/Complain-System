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

            <!-- Edit Profile Form -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                    <a href="<?= base_url('User/tenants') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Profile
                    </a>
                </div>

                <form action="<?= base_url('User/tenants/update') ?>" method="post" class="space-y-6">
                    <!-- Personal Information -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Full Name -->
                            <div>
                                <label for="full_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="full_name" name="full_name" value="<?= esc($tenant['full_name'] ?? '') ?>" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('full_name')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('full_name') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Username -->
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" id="username" name="username" value="<?= esc($tenant['username'] ?? '') ?>" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('username')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('username') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" id="email" name="email" value="<?= esc($tenant['email'] ?? '') ?>" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('email')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('email') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" id="phone" name="phone" value="<?= esc($tenant['phone'] ?? '') ?>" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('phone')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('phone') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" id="address" name="address" value="<?= esc($tenant['address'] ?? '') ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('address')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('address') ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Birthdate -->
                            <div>
                                <label for="birthdate" class="block text-sm font-medium text-gray-700 mb-1">Birthdate</label>
                                <input type="date" id="birthdate" name="birthdate" value="<?= esc($tenant['birthdate'] ?? '') ?>"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('birthdate')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('birthdate') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                    
                    <!-- Password Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password (optional)</h3>
                        <p class="text-sm text-gray-600 mb-4">Leave blank if you don't want to change your password.</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Old Password -->
                            <div class="mb-4">
                                <label for="old_password" class="block text-sm font-medium text-gray-700 mb-1">Old Password</label>
                                <input type="password" id="old_password" name="old_password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('old_password')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('old_password') ?></p>
                                <?php endif; ?>
                            </div>
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('password') ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirm" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="password_confirm" name="password_confirm"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <?php if (isset($validation) && $validation->hasError('password_confirm')): ?>
                                    <p class="text-red-500 text-xs mt-1"><?= $validation->getError('password_confirm') ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-3">
                        <a href="<?= base_url('User/tenants') ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>