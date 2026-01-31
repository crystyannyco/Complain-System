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

            <!-- Tenant Profile -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">My Profile</h2>
                    <a href="<?= base_url('/User/tenants/edit') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">edit</span>
                        Edit Profile
                    </a>
                </div>

                <?php if (isset($tenant) && $tenant): ?>
                    <!-- Profile Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Header with status-based color -->
                        <?php
                        $statusClass = match((string)$tenant['status']) {
                            '1', 'active' => 'bg-green-100 text-green-600',
                            '0', 'inactive' => 'bg-red-100 text-red-600',
                            default => 'bg-gray-100 text-gray-800',
                        };
                        $headerClass = str_replace('text', 'bg', $statusClass);
                        ?>
                        <div class="<?= $headerClass ?> px-6 py-4 border-b">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-white">
                                    <?= esc($tenant['full_name']) ?>
                                    <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                        <?= esc($tenant['status_label'] ?? '—') ?>
                                    </span>
                                </h3>
                                <span class="material-icons text-white">person</span>
                            </div>
                        </div>
                        
                        <!-- Profile Content -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Personal Information -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase mb-4">Personal Information</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Username:</span>
                                            <span class="text-gray-800"><?= esc($tenant['username']) ?></span>
                                        </div>

                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Full Name:</span>
                                            <span class="text-gray-800"><?= esc($tenant['full_name']) ?></span>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Email:</span>
                                            <span class="text-gray-800"><?= esc($tenant['email']) ?></span>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Phone:</span>
                                            <span class="text-gray-800"><?= esc($tenant['phone']) ?></span>
                                        </div>
                                        
                                        <div class="flex items-start">
                                            <span class="text-gray-600 font-medium w-28">Address:</span>
                                            <span class="text-gray-800"><?= esc($tenant['address']) ?></span>
                                        </div>
                                        
                                        <?php if (!empty($tenant['birthdate'])): ?>
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Birthdate:</span>
                                            <span class="text-gray-800"><?= date('M d, Y', strtotime($tenant['birthdate'])) ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <!-- Accommodation Details -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-sm font-medium text-gray-500 uppercase mb-4">Accommodation Details</h4>
                                    <div class="space-y-3">
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Room Number:</span>
                                            <span class="text-gray-800"><?= esc($tenant['room_number'] ?? '—') ?></span>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Bed:</span>
                                            <span class="text-gray-800"><?= esc($tenant['bed_name'] ?? '—') ?></span>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Move In:</span>
                                            <span class="text-gray-800">
                                                <?= !empty($tenant['move_in']) ? date('M d, Y', strtotime($tenant['move_in'])) : '—' ?>
                                            </span>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            <span class="text-gray-600 font-medium w-28">Move Out:</span>
                                            <span class="text-gray-800">
                                                <?= !empty($tenant['move_out']) ? date('M d, Y', strtotime($tenant['move_out'])) : '—' ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-8">
                        <span class="material-icons text-gray-400 text-5xl mb-3">error_outline</span>
                        <p class="text-gray-500">Profile information not found. Please contact the administrator.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>