<?php
/**
 * 420DW3_07278_Project UserService.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

use Project\DAO\UserDAO;
use Project\DAO\UserGroupsDAO;

use Project\DTO\User;
use Project\DTO\UserGroups;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 * TODO: Class documentation UserService
 */
class UserService implements IService {
    private UserDAO $userDao;
    
    public function __construct() {
        $this->userDao = new UserDAO();
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
    public function createUser(string $username, string $password, string $email) : User {
        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);
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
     * TODO: Function documentation getUserById
     *
     * @param int $id
     * @return User|null
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getUserById(int $id) : ?User {
        return $this->userDao->getById($id);
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
    
}
