<?php
declare(strict_types=1);
/**
 * index.php loginHandler.php
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
class loginHandler {
    private UserService $userService;
    
    public function __construct() {
        $this->userService = new UserService();
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
     * TODO: Function documentation isLoggedIn
     *
     * @return bool
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function isLoggedIn() : bool {
        return isset($_SESSION["LOGGED_IN_USER"]);
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
    
}
