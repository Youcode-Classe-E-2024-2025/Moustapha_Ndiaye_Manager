<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../process/register_process.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipeShare</title>
    <link rel="stylesheet" href="assets/css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-yellow-500 min-h-screen flex flex-col">
    
    
    <!-- Navigation Buttons -->
    <div class="flex justify-end p-4 sm:p-6 md:p-8">
        <div class="flex space-x-2">
            <a href="login" id="showLogin" class="text-white font-semibold px-4 py-2 
                transition-all duration-200 ease-in-out rounded-full 
                bg-transparent border-2 border-white 
                hover:bg-white hover:text-yellow-500">Log in</a>

            <a href="register" id="showRegister" class="text-white font-semibold px-4 py-2 
                transition-all duration-200 ease-in-out rounded-full 
                bg-transparent border-2 border-white 
                hover:bg-white hover:text-yellow-500">Sign up</a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg flex flex-col md:flex-row">
            <!-- Image Section - Hidden on smaller screens -->
            <div class="hidden md:block md:w-1/2 p-4 lg:p-8">
                <img src="assets/img/register1.jpeg" alt="Register Image" class="rounded-xl w-full h-full object-cover">
            </div>

            <!-- Forms Section -->
            <div class="w-full md:w-1/2 p-4 lg:p-8 flex flex-col justify-center">
                <!-- Sign Up Form -->
                <div id="registerForm" class="w-full max-w-sm mx-auto">
                    <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 text-gray-700">Sign Up</h2>
                    
                    <form action="register" method="POST">
                        <div class="mb-3 md:mb-4">
                            <label for="name" class="block text-xs md:text-sm font-medium text-gray-600">Full Name</label>
                            <input type="text" id="name" name="name" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your full name"
                                value="">
                        </div>

                        <div class="mb-3 md:mb-4">
                            <label for="email" class="block text-xs md:text-sm font-medium text-gray-600">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your email"
                                value="">
                        </div>

                        <div class="mb-3 md:mb-4">
                            <label for="password" class="block text-xs md:text-sm font-medium text-gray-600">Password</label>
                            <input type="password" id="password" name="password" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your password">
                        </div>

                        <div class="mb-3 md:mb-4">
                            <label for="confirm_password" class="block text-xs md:text-sm font-medium text-gray-600">Confirm Password</label>
                            <input type="password" id="confirm_password" name="confirm_password" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Confirm your password">
                        </div>

                        <button type="submit"
                            class="w-full bg-yellow-500 text-white py-2 md:py-3 rounded-md 
                            font-semibold hover:bg-yellow-600 transition duration-200 text-sm md:text-base">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="fixed top-4 right-4 left-4 md:left-auto md:w-96 z-50">
            <?php foreach ($errors as $error): ?>
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-2 rounded shadow-md">
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <script src="../assets/js/main.js"></script>
</body>
</html>