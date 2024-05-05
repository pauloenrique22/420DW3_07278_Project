<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project UserService.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Services;

use Project\DAO\PermissionDAO;
use Project\DAO\UserDAO;
use Project\DAO\UserGroupsDAO;

use Project\DTO\User;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;
use Project\Services\DBConnectionServices;

require_once dirname(__DIR__, 3) . '/helpers/init.php';
require_once 'DBConnectionServices.php';

// UserService.php
$action = $_POST['action'] ?? null;

if ($action === 'createUser') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $userGroupId = $_POST['userGroupId'];
    
    $userService = new UserService();
    $createdUser = $userService->createUser($username, $password, $email, $userGroupId);
    
    // Retorne os dados do usuário criado como JSON
    echo json_encode($createdUser);
}
/**
 * TODO: Class documentation UserService
 */
class UserService {
    private UserDAO $userDao;
    private UserGroupsDAO $userGroupDao;
    private PermissionDAO $permissionDao;
    
    /**
     * @throws RuntimeException
     */
    public function __construct() {
        $pdo = DBConnectionServices::getConnection();
        $this->userDao = new UserDAO($pdo);
        $this->userGroupDao = new UserGroupsDAO($pdo);
        $this->permissionDao = new PermissionDAO($pdo);
    }
    
    /**
     * TODO: Function documentation createUser
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return User
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function createUser(string $username, string $password, string $email, int $userGroupId) : User {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
        $user->setUserGroupId($userGroupId);
        return $this->userDao->create($user);
    }
    
    /**
     * TODO: Function documentation getUser
     *
     * @param int $id
     * @return User
     * @throws RuntimeException
     *
     * @author PE-Oliver89
     * @since  2024-05-02
     */
    public function getUser(int $id) : User {
        return $this->userDao->getById($id);
    }
    
    
    /**
     * TODO: Function documentation getAllUsers
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAllUsers() : array {
        try {
            return $this->userDao->getAll();
        } catch (ValidationException|RuntimeException $exception) {
            return [$exception];
        }
    }
    
    /**
     * TODO: Function documentation updateUser
     *
     * @param int    $id
     * @param string $username
     * @param string $password
     * @param string $email
     * @return User
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function updateUser(int $id, string $username, string $password, string $email) : User {
        $user = $this->userDao->getById($id);
        $user->setUsername($username);
        $user->setPassword($password); // Ensure password is hashed
        $user->setEmail($email);
        return $this->userDao->update($user);
    }
    
    /**
     * TODO: Function documentation deleteUser
     *
     * @param int  $id
     * @param bool $hardDelete
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function deleteUser(int $id, bool $hardDelete = false) : void {
        $this->userDao->deleteById($id, $hardDelete);
    }
    
    /**
     * TODO: Function documentation authenticate
     *
     * @param string $username
     * @param string $password
     * @return int|null
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function authenticate(string $username, string $password) : ?int {
        try {
            $user = $this->userDao->getByUsername($username);
        } catch (ValidationException|RuntimeException $exception) {
            error_log("Error Authenticate getByUsername: " . $exception->getMessage());
            return null;
        }
        if (!$user) {
            error_log("User not found for username: $username");
            return null;
        }
        
        error_log("User password: " . $user->getPassword());
        
        if (password_verify($password, $user->getPassword())) {
            error_log("Password match");
            return $user->getId();
        } else {
            error_log("Password mismatch");
            return null;
        }
    }
    
    /**
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function getUserPermissions(int $userId) : array {
        return $this->permissionDao->getUserPermissions($userId);
        
    }
}
