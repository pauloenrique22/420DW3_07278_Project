<?php
declare(strict_types=1);

use Project\Services\LoginHandler;
use Project\Services\UserService;
use Project\Controllers\UserController;

require_once dirname(__DIR__, 3) . '/private/src/Project/Services/LoginHandler.php';
require_once dirname(__DIR__, 3) . '/private/src/Project/Services/UserService.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$userService = new UserService();
$loginFunctions = new LoginHandler();

if(!$loginFunctions->isLoggedIn()){
    $_SESSION['error'] = 'You must be logged in to access this page.';
    header("Location: " . WEB_PAGES_DIR . "Project/login.php");
    exit;
}

if (!$loginFunctions->hasPermission('LOGIN_ALLOWED')) {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    header("Location: " . WEB_PAGES_DIR . "Project/HomePage.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'bootstrap.min.css' ?>">
    <link rel="stylesheet" href="<?= WEB_CSS_DIR . 'style.css' ?>">
    <script src="<?= WEB_JS_DIR . 'jquery-3.7.1.min.js' ?>"></script>
    <script type="text/javascript" src="<?= WEB_JS_DIR . "user.js" ?>" defer></script>
    <script type="text/javascript">
        var baseUrl = '<?= WEB_ROOT_DIR ?>';
    </script>
</head>
<body class="forms-page">
<div class="container-form">
    <h1>User Management</h1>
    <br>
    <div class="row">
        <div class="col1">
            <h2>User Operations</h2>
            <form id="userCrudForm">
                <!-- User ID input -->
                <!--<div class="input-form">
                    <label for="userIdInput" class="form-label">User ID</label>
                    <input type="text" class="form-control" id="userIdInput" name="userId" placeholder="User ID" readonly>
                </div>-->
                <!-- Username input -->
                <div class="input-form">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input type="text" class="form-control" id="usernameInput" name="username" placeholder="Username" required>
                </div>
                <!-- Password input -->
                <div class="input-form">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password" placeholder="Password" required>
                </div>
                <!-- Email input -->
                <div class="input-form">
                    <label for="emailInput" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="Email" required>
                </div>
                <!-- Form buttons -->
                <button type="button" class="btn-create" onclick="createUser()">Create</button>
                <button type="button" class="btn-update" onclick="updateUser()">Update</button>
                <button type="button" class="btn-delete" onclick="deleteUser()">Delete</button>
            </form>
        </div>
        <div class="col2">
            <h2>User Search and Display</h2>
            <label for="userIdSelect">Select User to Search:</label>
            <select class="form-control" id="userIdSelect">
            </select>
            <button type="button" class="btn-search" id="userIdSelect" onclick="searchByUserId()">Search by ID</button>
            <button type="button" class="btn-allUser" onclick="fetchAllUsers()">Display All Users</button>
            <div id="allUsersDisplay">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                    </tr>
                    </thead>
                    <tbody id="allUsersBody">
                    <!-- Rows will be dynamically added here -->
                    </tbody>
                </table>
            </div>
            <div class="col3">
                <h2>Deleted Users</h2>
                <button type="button" class="btn-view-deleted" onclick="fetchDeletedUsers()">Display Deleted Users</button>
                <div id="deletedUsersDisplay">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                        </tr>
                        </thead>
                        <tbody id="deletedUsersBody">
                        <!-- Deleted user rows will be dynamically added here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!--    <div class="row2">
            <div class="col3">
                <h2>Group Membership Management</h2>
                <form id="groupManagementForm">
                    <div class="input-form">
                        <label for="groupIdInput" class="form-label">Group ID</label>
                        <input type="text" class="form-control" id="groupIdInput" name="groupId" placeholder="Group ID">
                    </div>
                    <button type="button" class="btn-add-to-group" onclick="addUserToGroup()">Add to Group</button>
                    <button type="button" class="btn-remove-from-group" onclick="removeUserFromGroup()">Remove from Group</button>
                </form>
            </div>
        </div>-->
</div>

<!--<div>
    <h2>DEBUG / INFO DATA</h2>
    <div id="debugContents"></div>
</div>-->

</body>
</html>
