<?php
// admin_actions.php
require_once '../config/database.php';

session_start();

// Vérifier si l'utilisateur est un admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('HTTP/1.1 403 Forbidden');
    exit('Accès non autorisé');
}

$action = $_REQUEST['action'] ?? '';
$pdo = db_connect();

switch ($action) {
    case 'get_users':
        $stmt = $pdo->query("
            SELECT user_id, Fname, Lname, email, role, registration_date, 
                   (SELECT COUNT(*) FROM RECIPE WHERE RECIPE.user_id = USERS.user_id) as recipe_count,
                   (SELECT COUNT(*) FROM COMMENT WHERE COMMENT.user_id = USERS.user_id) as comment_count
            FROM USERS 
            WHERE archived = 0
            ORDER BY registration_date DESC
        ");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="overflow-x-auto">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Gestion des Utilisateurs</h2>
                <button onclick="loadContent('add_user')"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ajouter un utilisateur
                </button>
            </div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Rôle</th>
                        <th class="px-6 py-3 text-left">Date d'inscription</th>
                        <th class="px-6 py-3 text-left">Recettes</th>
                        <th class="px-6 py-3 text-left">Commentaires</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-t">
                            <td class="px-6 py-4"><?= htmlspecialchars($user['Fname'] . ' ' . $user['Lname']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="px-6 py-4"><?= htmlspecialchars($user['role']) ?></td>
                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($user['registration_date'])) ?></td>
                            <td class="px-6 py-4"><?= $user['recipe_count'] ?></td>
                            <td class="px-6 py-4"><?= $user['comment_count'] ?></td>
                            <td class="px-6 py-4">
                                <button onclick="loadContent('edit_user?id=<?= $user['user_id'] ?>')"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                    Éditer
                                </button>
                                <button onclick="confirmAction('archive_user', <?= $user['user_id'] ?>, 'user')"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Archiver
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
        break;

    case 'get_recipes':
        $stmt = $pdo->query("
            SELECT recipe_id, title, creation_date, 
                   (SELECT COUNT(*) FROM COMMENT WHERE COMMENT.recipe_id = RECIPE.recipe_id) as comment_count,
                   (SELECT COUNT(*) FROM RATING WHERE RATING.recipe_id = RECIPE.recipe_id) as rating_count
            FROM RECIPE 
            WHERE archived = 0
            ORDER BY creation_date DESC
        ");
        $recipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="overflow-x-auto">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Gestion des Recettes</h2>
                <button onclick="loadContent('add_recipe')"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ajouter une recette
                </button>
            </div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Titre</th>
                        <th class="px-6 py-3 text-left">Date de création</th>
                        <th class="px-6 py-3 text-left">Commentaires</th>
                        <th class="px-6 py-3 text-left">Evaluations</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recipes as $recipe): ?>
                        <tr class="border-t">
                            <td class="px-6 py-4"><?= htmlspecialchars($recipe['title']) ?></td>
                            <td class="px-6 py-4"><?= date('d/m/Y', strtotime($recipe['creation_date'])) ?></td>
                            <td class="px-6 py-4"><?= $recipe['comment_count'] ?></td>
                            <td class="px-6 py-4"><?= $recipe['rating_count'] ?></td>
                            <td class="px-6 py-4">
                                <button onclick="loadContent('edit_recipe?id=<?= $recipe['recipe_id'] ?>')"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                    Éditer
                                </button>
                                <button onclick="confirmAction('archive_recipe', <?= $recipe['recipe_id'] ?>, 'recipe')"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Archiver
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
        break;

    case 'get_categories':
        $stmt = $pdo->query("SELECT category_id, name FROM RECIPE_CATEGORY WHERE archived = 0 ORDER BY name");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="overflow-x-auto">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Gestion des Catégories</h2>
                <button onclick="loadContent('add_category')"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ajouter une catégorie
                </button>
            </div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr class="border-t">
                            <td class="px-6 py-4"><?= htmlspecialchars($category['name']) ?></td>
                            <td class="px-6 py-4">
                                <button onclick="loadContent('edit_category?id=<?= $category['category_id'] ?>')"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                    Éditer
                                </button>
                                <button onclick="confirmAction('archive_category', <?= $category['category_id'] ?>, 'category')"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Archiver
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php
        break;

    case 'get_ingredients':
        $stmt = $pdo->query("SELECT ingredient_id, name FROM INGREDIENT WHERE archived = 0 ORDER BY name");
        $ingredients = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
        <div class="overflow-x-auto">
            <div class="flex justify-between mb-4">
                <h2 class="text-2xl font-bold">Gestion des Ingrédients</h2>
                <button onclick="loadContent('add_ingredient')"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                    Ajouter un ingrédient
                </button>
            </div>
            <table class="min-w-full bg-white">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <tr class="border-t">
                            <td class="px-6 py-4"><?= htmlspecialchars($ingredient['name']) ?></td>
                            <td class="px-6 py-4">
                                <button onclick="loadContent('edit_ingredient?id=<?= $ingredient['ingredient_id'] ?>')"
                                    class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 mr-2">
                                    Éditer
                                </button>
                                <button onclick="confirmAction('archive_ingredient', <?= $ingredient['ingredient_id'] ?>, 'ingredient')"
                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    Archiver
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php
        break;

    case 'get_comments':
        // Si la colonne archived existe maintenant, tu peux filtrer les commentaires non archivés
        $stmt = $pdo->query("SELECT comment_id, content, creation_date FROM COMMENT WHERE archived = 0 ORDER BY creation_date DESC");

        if (!$stmt) {
            die("Erreur SQL : " . implode(", ", $pdo->errorInfo()));
        }

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($comments)) {
            echo "<p>Aucun commentaire disponible.</p>";
        } else {
        ?>
            <div class="overflow-x-auto">
                <div class="flex justify-between mb-4">
                    <h2 class="text-2xl font-bold">Gestion des Commentaires</h2>
                </div>
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left">Contenu</th>
                            <th class="px-6 py-3 text-left">Date de création</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr class="border-t">
                                <td class="px-6 py-4"><?= htmlspecialchars($comment['content']) ?></td>
                                <td class="px-6 py-4"><?= date('d/m/Y', strtotime($comment['creation_date'])) ?></td>
                                <td class="px-6 py-4">
                                    <button onclick="confirmAction('archive_comment', <?= $comment['comment_id'] ?>, 'comment')"
                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Archiver
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
<?php
        }
        break;


    default:
        echo "Action non reconnue";
        break;
}
?>