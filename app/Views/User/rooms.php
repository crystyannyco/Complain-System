<!-- Updated rooms.php view file -->
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
        
            <!-- Rooms List -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Rooms & Beds Management</h2>
                    <a href="<?= base_url('rooms/add') ?>" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">add</span>
                        Add New Room
                    </a>
                </div>
                
                <!-- Rooms Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Room #</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bed</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Capacity</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Move In</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Move Out</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $room['room_number'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $room['bed_name'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= !empty($room['tenant_name']) ? esc($room['tenant_name']) : '—' ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= $room['capacity'] ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= !empty($room['move_in']) ? date('M d, Y', strtotime($room['move_in'])) : '—' ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap"><?= !empty($room['move_out']) ? date('M d, Y', strtotime($room['move_out'])) : '—' ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php
                                            $statusClass = '';
                                            switch($room['status']) {
                                                case 0:
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 1:
                                                    $statusClass = 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 2:
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 3:
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $statusClass = 'bg-gray-100 text-gray-800';
                                            }
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $statusClass ?>">
                                                <?= $room['status_label'] ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="<?= base_url('rooms/edit/'.$room['room_id']) ?>" class="text-indigo-600 hover:text-indigo-900 mr-3 transition duration-300 ease-in-out flex items-center inline-flex">
                                                <span class="mr-1 material-icons">edit</span>
                                                Edit</a>
                                            <a href="<?= base_url('rooms/delete/'.$room['room_id']) ?>" class="text-red-600 hover:text-red-900 transition duration-300 ease-in-out flex items-center inline-flex" onclick="return confirm('Are you sure you want to delete this room?')">
                                                <span class="mr-1 material-icons">delete</span>
                                                Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No rooms found</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>