<?php
declare(strict_types=1);
/**
 * index.php LoginController.php
 *
 * @author   PE-Oliver89
 * @since    2024-05-01
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Controllers;

use Exception;
use Project\Services\UserService;

class LoginController {
    public static function doUserLogin() : void {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $userService = new UserService();
            
            try {
                $user_id = $userService->authenticate($username, $password);
                if ($user_id) {
                    $_SESSION['loggedin'] = true;
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['username'] = $username;
                    $_SESSION['permissions'] = $userService->getUserPermissions($user_id);
                    
                    // Redirect to the home page with a GET request
                    header("Location: " . WEB_ROOT_DIR . "home");
                    exit;
                } else {
                    // Authentication failed, prepare error message for the user
                    $error = 'Invalid username or password.';
                }
            } catch (Exception $exception) {
                $error = 'An error occurred during login.';
            }
            
        }
    }
}