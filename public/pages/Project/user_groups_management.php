<?php
declare(strict_types=1);
/**
 * user_groups_management.php
 *
 * @author   PE-Oliver89
 * @since    2024-05-01
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */
include_once __DIR__ . "/../../../private/helpers/init.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$user_groups = new \Project\Services\UserGroupService();

try {
    $userGroupDAO = new Project\DAO\UserGroupsDAO();
    $user_groups = $userGroupDAO->getAll();
} catch (\Teacher\GivenCode\Exceptions\ValidationException $e) {
    $error = $e->getMessage();
} catch (\Teacher\GivenCode\Exceptions\RuntimeException $e) {
    $error = $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Groups</title>
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
    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form action="<?= WEB_ROOT_DIR . 'Services/LoginHandler.php' ?>" method="post">
        <h1>Welcome to your User Groups Management</h1>
    </form>
</div>
<div class="table-container">
    <h2>User Groups</h2>
    <table>
        <tr>
            <th>Name</th>
        </tr>
        <?php foreach ($user_groups as $user_group): ?>
            <tr>
                <td><?= htmlspecialchars($user_group->getGroupName()) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>