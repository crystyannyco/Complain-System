<!-- Main Content -->
<main class="flex-1 w-full py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow overflow-hidden w-full">
        <!-- Profile Header -->
        <div class="bg-blue-600 h-32 md:h-48 w-full"></div>
        <div class="px-6 py-5 relative">
            <div class="absolute -top-16 left-6">
                <div class="h-32 w-32 rounded-full border-4 border-white bg-white shadow-lg overflow-hidden">
                    <div class="h-full w-full bg-blue-100 flex items-center justify-center">
                        <span class="material-icons text-blue-600 text-6xl">person</span>
                    </div>
                </div>
            </div>
            <div class="mt-16 md:mt-0 md:ml-36 flex flex-col md:flex-row md:justify-between md:items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Michael Johnson</h2>
                    <p class="text-gray-600">System Administrator</p>
                </div>
                <div class="mt-4 md:mt-0 flex space-x-3">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-2 text-sm">edit</span>
                        Edit Profile
                    </button>
                    <button class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-md flex items-center">
                        <span class="material-icons mr-2 text-sm">security</span>
                        Change Password
                    </button>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-3">
                <!-- Personal Information -->
                <div class="p-6 border-b md:border-b-0 md:border-r border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <span class="material-icons mr-2 text-blue-600">person</span>
                        Personal Information
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Full Name</p>
                            <p class="text-gray-900">Michael Robert Johnson</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="text-gray-900">June 15, 1985</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Gender</p>
                            <p class="text-gray-900">Male</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Employee ID</p>
                            <p class="text-gray-900">ADM-2023-0451</p>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="p-6 border-b md:border-b-0 md:border-r border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <span class="material-icons mr-2 text-blue-600">contact_phone</span>
                        Contact Information
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email Address</p>
                            <p class="text-gray-900">michael.johnson@example.com</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Work Phone</p>
                            <p class="text-gray-900">(555) 123-4567</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Mobile Phone</p>
                            <p class="text-gray-900">(555) 987-6543</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Address</p>
                            <p class="text-gray-900">1234 Administration Blvd, Suite 500</p>
                            <p class="text-gray-900">San Francisco, CA 94107</p>
                        </div>
                    </div>
                </div>
                
                <!-- System Information -->
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4 flex items-center">
                        <span class="material-icons mr-2 text-blue-600">admin_panel_settings</span>
                        System Information
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Role</p>
                            <p class="text-gray-900">System Administrator</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Department</p>
                            <p class="text-gray-900">Information Technology</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Access Level</p>
                            <div class="flex items-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    Full Access
                                </span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Account Created</p>
                            <p class="text-gray-900">March 10, 2023</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Last Login</p>
                            <p class="text-gray-900">April 27, 2025 - 09:45 AM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>