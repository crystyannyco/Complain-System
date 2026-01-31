<!-- Main Content -->
<div class="flex-1 flex flex-col overflow-hidden">
    <main class="flex-1 overflow-y-auto">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Add Announcement</h2>
                    <a href="<?= base_url('announcements') ?>" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-1">arrow_back</span>
                        Back to Announcements
                    </a>
                </div>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        <ul class="list-disc pl-5">
                            <?php foreach ((array) session()->getFlashdata('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('announcements/add') ?>" method="post">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="title" class="block text-gray-700 font-medium mb-2">Title *</label>
                            <input type="text" id="title" name="title" 
                                value="<?= old('title') ?>"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.title') ? 'border-red-500' : '' ?>">
                            <?php if (session()->getFlashdata('errors.title')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.title') ?></p>
                            <?php endif; ?>
                        </div>

                        <div class="mb-4 col-span-1 md:col-span-2">
                            <label for="content" class="block text-gray-700 font-medium mb-2">Content *</label>
                            <textarea id="content" name="content" rows="5"
                                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 <?= session()->getFlashdata('errors.content') ? 'border-red-500' : '' ?>"><?= old('content') ?></textarea>
                            <?php if (session()->getFlashdata('errors.content')): ?>
                                <p class="text-red-500 text-xs mt-1"><?= session()->getFlashdata('errors.content') ?></p>
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
