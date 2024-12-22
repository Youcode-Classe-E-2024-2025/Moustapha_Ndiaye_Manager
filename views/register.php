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
                <?php if (isset($_GET['registerIN']) && $_GET['registerIN'] == 1): ?>
                    <div class="bg-black border-l-4 border-red-500 text-white p-4 mb-4" role="alert">
                        <p class="font-bold">Error!</p>
                        <ul>
                            <?php
                            // Vérification si 'errors' est défini et si c'est une chaîne de caractères
                            if (isset($_GET['errors']) && is_string($_GET['errors'])) {
                                // Désérialiser les erreurs
                                parse_str($_GET['errors'], $errors);

                                // Afficher les erreurs pour chaque champ
                                foreach ($errors as $field => $error) {
                                    echo "<li><strong>$field:</strong> $error</li>";
                                }
                            } elseif (isset($_GET['errors']) && is_array($_GET['errors'])) {
                                // Si errors est déjà un tableau, directement afficher les erreurs
                                foreach ($_GET['errors'] as $field => $error) {
                                    echo "<li><strong>$field:</strong> $error</li>";
                                }
                            }
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Sign Up Form -->
                <div id="registerForm" class="w-full max-w-sm mx-auto">
                    <h2 class="text-2xl md:text-3xl font-bold text-center mb-6 text-gray-700">Sign Up</h2>

                    <form action="register" method="POST">
                        <div class="mb-3 md:mb-4">
                            <label for="fname" class="block text-xs md:text-sm font-medium text-gray-600">Fisrt Name</label>
                            <input type="text" id="name" name="fname" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
            border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="First name"
                                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>">

                        </div>
                        <div class="mb-3 md:mb-4">
                            <label for="lname" class="block text-xs md:text-sm font-medium text-gray-600">Last Name</label>
                            <input type="text" id="name" name="lname" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
            border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Last name"
                                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>">
                        </div>

                        <div class="mb-3 md:mb-4">
                            <label for="email" class="block text-xs md:text-sm font-medium text-gray-600">Email</label>
                            <input type="email" id="email" name="email" required
                                class="w-full mt-1 md:mt-2 p-2 md:p-3 text-sm md:text-base 
            border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500"
                                placeholder="Your email"
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>">
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

    
    <script src="../assets/js/main.js"></script>
</body>

</html>