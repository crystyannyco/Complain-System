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
            <!-- Edit Feedback Form Container -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Edit Feedback</h2>
                    <a href="<?= base_url('feedbacks') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Feedbacks
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

                <form action="<?= base_url('feedbacks/update/' . $feedback['id']) ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="resident_name" class="block text-gray-700 font-medium mb-2">Resident *</label>
                            <input type="text" id="resident_name" 
                                value="<?= $feedback['resident_name'] ?? 'Unknown' ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500">
                            <input type="hidden" id="user_id" name="user_id" 
                                value="<?= old('user_id', $feedback['user_id']) ?>">
                        </div>

                        <div class="mb-4">
                            <label for="room_bed" class="block text-gray-700 font-medium mb-2">Room & Bed</label>
                            <input type="text" id="room_bed" 
                                value="<?= $feedback['room'] ?? 'Not Assigned' ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 readonly focus:ring-blue-500">
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="feedback_type" class="block text-gray-700 font-medium mb-2">Feedback Type *</label>
                            <select id="feedback_type" name="feedback_type"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.feedback_type') ? 'border-red-500' : '' ?>">
                                <option value="">-- Select Feedback --</option>

                                <optgroup label="Positive Feedback">
                                    <option value="1" <?= old('feedback_type', $feedback['feedback_type']) == '1' ? 'selected' : '' ?>>The admin is very responsive. Thank you!</option>
                                    <option value="2" <?= old('feedback_type', $feedback['feedback_type']) == '2' ? 'selected' : '' ?>>Common areas are always clean — good job to the cleaning staff.</option>
                                    <option value="3" <?= old('feedback_type', $feedback['feedback_type']) == '3' ? 'selected' : '' ?>>I love the quiet environment here.</option>
                                    <option value="4" <?= old('feedback_type', $feedback['feedback_type']) == '4' ? 'selected' : '' ?>>The new security lights outside are really helpful.</option>
                                    <option value="5" <?= old('feedback_type', $feedback['feedback_type']) == '5' ? 'selected' : '' ?>>Maintenance requests are always handled quickly.</option>
                                    <option value="6" <?= old('feedback_type', $feedback['feedback_type']) == '6' ? 'selected' : '' ?>>The new Wi-Fi router placement improved the signal.</option>
                                </optgroup>

                                <optgroup label="Neutral Feedback">
                                    <option value="7" <?= old('feedback_type', $feedback['feedback_type']) == '7' ? 'selected' : '' ?>>Suggestion: Install a CCTV near the hallway.</option>
                                    <option value="8" <?= old('feedback_type', $feedback['feedback_type']) == '8' ? 'selected' : '' ?>>Please consider adding a drying area for laundry.</option>
                                    <option value="9" <?= old('feedback_type', $feedback['feedback_type']) == '9' ? 'selected' : '' ?>>It would be nice to have more cooking space.</option>
                                    <option value="10" <?= old('feedback_type', $feedback['feedback_type']) == '10' ? 'selected' : '' ?>>More garbage bins on each floor would help a lot.</option>
                                </optgroup>

                                <optgroup label="Negative Feedback">
                                    <option value="11" <?= old('feedback_type', $feedback['feedback_type']) == '11' ? 'selected' : '' ?>>Sometimes the CR is not cleaned properly.</option>
                                    <option value="12" <?= old('feedback_type', $feedback['feedback_type']) == '12' ? 'selected' : '' ?>>Too much noise on weekends — no clear enforcement of rules.</option>
                                    <option value="13" <?= old('feedback_type', $feedback['feedback_type']) == '13' ? 'selected' : '' ?>>Wi-Fi goes down during peak hours, very frustrating.</option>
                                    <option value="14" <?= old('feedback_type', $feedback['feedback_type']) == '14' ? 'selected' : '' ?>>Laundry drying area gets overcrowded every day.</option>
                                </optgroup>
                            </select>
                            <?php if (session()->getFlashdata('errors.feedback_type')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.feedback_type') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="description" class="block text-gray-700 font-medium mb-2">Description *</label>
                            <textarea id="description" name="description" rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.description') ? 'border-red-500' : '' ?>"><?= old('description', $feedback['description']) ?></textarea>
                            <?php if (session()->getFlashdata('errors.description')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.description') ?></p>
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