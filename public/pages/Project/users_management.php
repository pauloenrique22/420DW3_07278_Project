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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
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
            <li><a href="logout.php">Logout</a></li>
        </div>
    </ul>
</nav>
<div class="container-form">
    <h1>User Management</h1><br><br><br>
    <div class="row">
        <div class="">
            <h2>User Information</h2>
            <form id="userForm">
                <div class="input-form">
                    <label for="userIdInput" class="form-label">User ID</label>
                    <input type="text" class="form-control" id="userIdInput" name="userId" placeholder="User ID"
                           readonly>
                </div>
                <div class="input-form">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input type="text" class="form-control" id="usernameInput" name="username" placeholder="Username"
                           required>
                </div>
                <div class="input-form">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password"
                           placeholder="Password" required>
                </div>
                <div class="input-form">
                    <label for="emailInput" class="form-label">Email</label>
                    <input type="email" class="form-control" id="emailInput" name="email" placeholder="Email" required>
                </div>
                <div class="wrap-button">
                    <button type="button" class="btn-operation" onclick="createUser()">Create</button>
                    <button type="button" class="btn-operation" onclick="updateUser()">Update</button>
                    <button type="button" class="btn-operation" onclick="deleteUser()">Delete</button>
                </div>
            </form>
        </div>
        
        <div class="">
            <h2>Search or Display</h2>
            <label for="userIdSelect">Select User ID to Search:</label>
            <select class="form-control-user" id="userIdSelect">
                <!-- Options will be populated here using jQuery -->
            </select>
            <div class="wrap-button">
                <button type="button" class="btn-operation" onclick="searchByUserId()">Search by User ID</button>
                <button type="button" class="btn-operation" onclick="fetchAllUsers()">Display All Users</button>
            </div>
            <div id="searchResults" class="mb-3"></div>
        </div>
    </div>
</div>
</body>
</html>