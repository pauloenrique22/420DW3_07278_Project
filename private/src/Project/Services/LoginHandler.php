<?php
declare(strict_types=1);
/**
 * LoginHandler.php
 *
 * @author   PE-Oliver89
 * @since    2024-05-01
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Services;

use Project\Services\UserService;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 *  Class LoginHandler
 */
class LoginHandler implements IService {
    private UserService $userService;
    
    public function __construct() {
        $this->userService = new UserService();
    }
    
    public static function isLoggedIn() : bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
        
        $hasLoginPermission = in_array('LOGIN_ALLOWED', $_SESSION['permissions'] ?? []);
        
        return $isLoggedIn && $hasLoginPermission;
    }
    
    
    /**
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function login(string $email, string $password) : void {
        error_log("Email: $email");
        error_log("Password: $password");
        $user_id = $this->userService->authenticate($email, $password);
        error_log("User ID: $user_id");
        
        if ($user_id === null) {
            throw new RuntimeException("User not found");
        }
        setcookie("nome_do_cookie", "valor_do_cookie", time() + (86400 * 30), "/");
        $_SESSION["LOGGED_IN_USER"] = $user_id;
        $_SESSION["permissions"] = $this->userService->getUserPermissions($user_id);
    }
    
    /**
     * TODO: Function documentation logout
     *
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function logout() : void {
        session_destroy();
    }
    
    /**
     * TODO: Function documentation hasPermission
     *
     * @param string $permissionKey
     * @return bool
     *
     * @author PE-Oliver89
     * @since  2024-05-04
     */
    public function hasPermission(string $permissionKey) : bool {
        return in_array($permissionKey, $_SESSION["permissions"] ?? []);
    }
    
    
}
