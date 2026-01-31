<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add New Tenant</h2>
                    <a href="<?= base_url('tenants') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span> Back to Tenants
                    </a>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <?php if (is_array(session()->getFlashdata('errors'))): ?>
                            <ul class="list-disc pl-5">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
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

                <form action="<?= base_url('tenants/add') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Full Name *</label>
                            <input type="text" name="full_name" value="<?= old('full_name') ?>" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.full_name') ? 'border-red-500' : '' ?>">
                        </div>
                        <!-- Username -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Username *</label>
                            <input type="text" name="username" value="<?= old('username') ?>" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.username') ? 'border-red-500' : '' ?>" >
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email *</label>
                            <input type="email" name="email" value="<?= old('email') ?>" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.email') ? 'border-red-500' : '' ?>">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Phone *</label>
                            <input type="text" name="phone" value="<?= old('phone') ?>" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.phone') ? 'border-red-500' : '' ?>">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Address</label>
                            <input type="text" name="address" value="<?= old('address') ?>" class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Birthdate</label>
                            <input type="date" name="birthdate" value="<?= old('birthdate') ?>" class="w-full px-4 py-2 border rounded-md">
                        </div>

                        <!-- Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Password *</label>
                            <input type="password" name="password" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.password') ? 'border-red-500' : '' ?>" >
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Confirm Password *</label>
                            <input type="password" name="password_confirm" class="w-full px-4 py-2 border rounded-md <?= session()->getFlashdata('errors.password_confirm') ? 'border-red-500' : '' ?>" >
                        </div>

                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-md flex items-center">
                            <span class="material-icons mr-2">person_add</span>
                            Add Tenant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>