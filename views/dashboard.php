<!-- dashboard.php -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipeShare</title>
    <link rel="stylesheet" href="assets/css/output.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="bg-yellow-500">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white text-black">
            <div class="p-4">
                <h1 class="text-2xl font-bold">Admin Panel</h1>
            </div>
            <nav class="mt-4">
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100 active-nav"
                    data-target="users">
                    Utilisateurs
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100"
                    data-target="recipes">
                    Recettes
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100"
                    data-target="categories">
                    Catégories
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100"
                    data-target="ingredients">
                    Ingrédients
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-100"
                    data-target="comments">
                    Commentaires
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <div id="content" class="bg-white rounded-lg shadow p-6">
                <!-- Le contenu sera chargé ici dynamiquement -->
            </div>
        </main>
    </div>

    <!-- Modal de confirmation -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold mb-4">Confirmer l'action</h3>
            <p id="modalMessage">Êtes-vous sûr de vouloir effectuer cette action ?</p>
            <div class="mt-4 flex justify-end gap-4">
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                    Annuler
                </button>
                <button id="confirmBtn" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                    Confirmer
                </button>
            </div>
        </div>
    </div>

    <script src="../assets/js/main.js"></script>
</body>

</html>