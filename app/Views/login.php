<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        @media (max-width: 768px) {
            .mobile-full-height {
                min-height: 100vh;
            }
        }
    </style>
</head>
<body class="bg-gray-200">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Login Section -->
        <div class="w-full md:w-1/2 flex items-center justify-center bg-gray-500 p-4 sm:p-6 mobile-full-height">
            <div class="w-full max-w-md px-4">
                <div class="text-center mb-6 md:mb-8">
                    <!-- Logo added here -->
                    <div class="flex justify-center mb-4">
                        <img src="\assets\logo.png" alt="Oida Boarding House Logo" class="h-16 md:h-20 w-auto">
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-white">Welcome to Oida's Boarding House</h1>
                    <p class="mt-2 text-sm md:text-base text-gray-100">Please sign in to continue</p>
                </div>
                
                <form class="space-y-4 md:space-y-6" action="<?= base_url('login') ?>" method="post">
                    <div class="text-center mb-4">
                        <h1 class="text-xl md:text-2xl font-bold text-white">Login</h1>
                    </div>
                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <div>
                        <label for="email" class="block text-sm font-medium text-white">Email Address</label>
                        <input type="email" id="email" name="email" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    
                    <div>
                        <label for="password" class="block text-sm font-medium text-white">Password</label>
                        <input type="password" id="password" name="password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" required>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full flex justify-center py-2 md:py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-700 hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150">
                            Login
                        </button>
                    </div>
                    
                    <!-- Google login button (commented out) -->
                    <!-- <div>
                        <button type="button" class="w-full flex justify-center items-center py-3 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#FFC107"/>
                                <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#FF3D00"/>
                                <path d="M3.117,7.254l3.258,2.392c0.874-2.167,2.993-3.695,5.459-3.695c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C16.793,2.988,14.728,2,12.134,2C8.034,2,4.457,4.139,3.117,7.254z" fill="#4CAF50"/>
                                <path d="M12.545,22c2.583,0,4.93-0.988,6.705-2.588l-3.095-2.624c-1.052,0.902-2.417,1.457-3.921,1.457c-2.796,0-5.177-1.851-6.01-4.359l-3.345,2.57C4.223,19.416,8.084,22,12.545,22z" fill="#1976D2"/>
                            </svg>
                            Login with Google
                        </button>
                    </div> -->
                </form>
                
                <!-- <div class="mt-4 md:mt-6 text-center">
                    <a href="#" class="text-sm text-blue-400 hover:text-blue-500 transition duration-150">Forgot your password?</a>
                    <p class="mt-2 text-sm text-gray-200">
                        Don't have an account? <a href="#" class="font-medium text-blue-200 hover:text-blue-100 transition duration-150">Sign up</a>
                    </p>
                </div> -->
            </div>
        </div>
        
        <!-- Image Section -->
        <div class="hidden md:block md:w-1/2 bg-cover bg-center">
            <img src="https://images.unsplash.com/photo-1622127922040-13cab637ee78?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1080&q=80'" alt="Cozy study room" class="h-full w-full object-cover">
        </div>
    </div>
</body>
</html>