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
use Teacher\GivenCode\Services\DBConnectionService;

/**
 * TODO: Class documentation UserService
 */
class UserService implements IService {
    private UserDAO $userDao;
    private UserGroupsDAO $userGroupDao;
    private PermissionDAO $permissionDao;
    
    /**
     * @throws RuntimeException
     */
    public function __construct() {
        $pdo = DBConnectionService::getConnection();
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
     * TODO: Function documentation getAllUsers
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAllUsers() : array {
        return $this->userDao->getAll();
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
            $user_name_ret = $user->getUsername();
            error_log("User Authenticate Info: $user_name_ret");
        } catch (ValidationException|RuntimeException $exception) {
            return null;
        }
        if (!$user) {
            return null;
        }
        
        $user_id = $user->getId();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        error_log("User hashed: $hashed_password");
        return password_verify($password, $hashed_password) ? $user_id : null;
    }
    
    /**
     * @throws ValidationException
     * @throws RuntimeException
     */
    public function getUserPermissions(int $userId) : array {
        return $this->permissionDao->getUserPermissions($userId);
        
    }
    
}
