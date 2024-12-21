<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
require_once __DIR__ . '/../process/login_process.php'; 
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
            
            <a href="/register" id="showRegister" class="text-white font-semibold px-4 py-2 
                transition-all duration-200 ease-in-out rounded-full 
                bg-transparent border-2 border-white 
                hover:bg-white hover:text-yellow-500">Sign up</a>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="flex-grow flex items-center justify-center px-4 py-8">
        <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg 
            flex flex-col md:flex-row">
            
            <!-- Image Section - Hidden on smaller screens -->
            <div class="hidden md:block md:w-1/2 p-4 lg:p-8">
                <img src="assets/img/register.jpg" alt="Register Image" 
                    class="rounded-xl w-full h-full object-cover">
            </div>

            <!-- Forms Section -->
            <div class="w-full md:w-1/2 p-4 lg:p-8 flex flex-col justify-center">
                <!-- Display confirmation message if user is redirected after registration -->
                <?php if (isset($_GET['registered']) && $_GET['registered'] == '1'): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                        <p class="font-bold">Registration Successful!</p>
                        <p>You can now log in with your credentials.</p>
                    </div>
                <?php endif; ?>
                <?php if ((isset($_GET['loginIn']) && $_GET['loginIn'] == 1)): ?>
                    <div class="bg-black border-l-4 border-red-500 text-white p-4 mb-4" role="alert">
                        <p class="font-bold">Error!</p>
                        <p>Please enter your correct credentials or register yourself.</p>
                    </div>
                <?php endif; ?>

                <!-- Login Form -->
                <div id="loginForm" class="w-full max-w-sm mx-auto ">
                    <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 text-gray-700">Log In</h2>

                    <form action="login" method="POST" id="loginForm">
                        <!-- Login form fields -->
                        <div class="mb-3 md:mb-4">
                            <label for="login_email" class="block text-xs md:text-sm font-medium text-gray-600">Email</label>
                            <input type="email" id="login_email" name="email" required 
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your email">
                        </div>

                        <div class="mb-3 md:mb-4">
                            <label for="login_password" class="block text-xs md:text-sm font-medium text-gray-600">Password</label>
                            <input type="password" id="login_password" name="password" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
                                border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your password">
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-center mb-3 md:mb-4">
                        
                            <a href="#" class="text-xs md:text-sm text-blue-500 hover:underline">Forgot password?</a>
                        </div>

                        <button type="submit"
                            class="w-full bg-yellow-500 text-white py-2 md:py-3 rounded-md 
                            font-semibold hover:bg-yellow-600 transition duration-200 text-sm md:text-base">
                            Log In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/main.js"></script>

</body>
</html>
