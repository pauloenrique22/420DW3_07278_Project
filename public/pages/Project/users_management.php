<?php
declare(strict_types=1);
/**
 * users_management.php
 *
 * @author   PE-Oliver89
 * @since    2024-05-01
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

use Project\Services\UserService;

include_once __DIR__ . "/../../../private/helpers/init.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and has the necessary permissions
if (!isset($_SESSION['user']) || !$_SESSION['user']->hasPermission('manage_users')) {
    header('Location: HomePage.php');
    exit();
}

// Include the UserService to handle user operations
include_once __DIR__ . "/../../../private/src/Project/Services/UserService.php";

$userService = new UserService();

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $userService->createUser($_POST['username'], $_POST['password'], $_POST['email'], $_POST['userGroupId']);
    } /*elseif (isset($_POST['update'])) {
        $userService->updateUser($_POST);
    } elseif (isset($_POST['delete'])) {
        $userService->deleteUser($_POST['id']);
    } elseif (isset($_POST['assign'])) {
        $userService->assignPermission($_POST['id'], $_POST['permission']);
    } elseif (isset($_POST['remove'])) {
        $userService->removePermission($_POST['id'], $_POST['permission']);
    }*/
}

// Get the list of users
$users = $userService->getUsers();

// Get the user details if a user is selected
$user = isset($_GET['id']) ? $userService->getUser($_GET['id']) : null;

// Get the list of permissions
$permissions = $userService->getPermissions();
?>

<!-- Your HTML code here -->

<!-- List of users -->
<ul>
    <?php foreach ($users as $user) : ?>
        <li><a href="?id=<?= $user->getId() ?>"><?= $user->getUsername() ?></a></li>
    <?php endforeach; ?>
</ul>

<!-- Form to create a new user -->
<form method="post">
    <!-- Your input fields here -->
    <input type="submit" name="create" value="Create User">
</form>

<?php if ($user) : ?>
    <!-- Form to update the user details -->
    <form method="post">
        <!-- Your input fields here, populated with the user details -->
        <input type="hidden" name="id" value="<?= $user->getId() ?>">
        <input type="submit" name="update" value="Update User">
    </form>

    <!-- Button to delete the user -->
    <form method="post">
        <input type="hidden" name="id" value="<?= $user->getId() ?>">
        <input type="submit" name="delete" value="Delete User">
    </form>

    <!-- Form to assign a permission to the user -->
    <form method="post">
        <select name="permission">
            <?php foreach ($permissions as $permission) : ?>
                <option value="<?= $permission->getId() ?>"><?= $permission->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id" value="<?= $user->getId() ?>">
        <input type="submit" name="assign" value="Assign Permission">
    </form>

    <!-- Form to remove a permission from the user -->
    <form method="post">
        <select name="permission">
            <?php foreach ($user->getPermissions() as $permission) : ?>
                <option value="<?= $permission->getId() ?>"><?= $permission->getName() ?></option>
            <?php endforeach; ?>
        </select>
        <input type="hidden" name="id" value="<?= $user->getId() ?>">
        <input type="submit" name="remove" value="Remove Permission">
    </form>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'style.css' ?>">
    <script src="<?= WEB_JS_DIR ?>script.js"></script>
</head>
<body class="home-background">
<nav>
    <ul>
        <li><a href="users_management.php">Users Management</a></li>
        <li><a href="user_groups_management.php">User Groups Management</a></li>
        <li><a href="permissions_management.php">Permissions Management</a></li>
        <div class="logout">
            <ul><li><a href="logout.php">Logout</a></li></ul>
        </div>
    </ul>
</nav>
<div>
    <form action="<?= WEB_ROOT_DIR . 'Services/UserService.php' ?>" method="post">
        <h1>User Management</h1>
        
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="userGroupId">User Group ID:</label><br>
        <input type="number" id="userGroupId" name="userGroupId" required><br>
        <br/><br/>
        <input type="submit" value="Submit">
    </form>
</div>
</body>
</html>