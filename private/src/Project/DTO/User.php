<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project User.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-24
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\DTO;

use DateTime;
use Teacher\GivenCode\Abstracts\AbstractDTO;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 * TODO: Class documentation User
 */
class User extends AbstractDTO {
    /**
     * TODO: Constant documentation TABLE_NAME
     */
    public const TABLE_NAME = "users";
    
    private const USERNAME_MAX_LENGTH = 30;
    private const EMAIL_MAX_LENGTH = 30;
    private const PASSWORD_MAX_LENGTH = 80;
    
    
    /* Variable */
    private string $username;
    private string $password;
    private string $email;
    private int $userGroupId;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;
    
    
    /**
     * TODO: Function documentation getDatabaseTableName
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-24
     */
    public function getDatabaseTableName() : string {
        return self::TABLE_NAME;
    }
    
    
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * TODO: Function documentation constructorFromValues
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @return User
     *
     * @throws ValidationException
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public static function constructorFromValues(string $username, string $password, string $email) : User {
        $object = new self();
        $object->setUsername($username);
        $object->setPassword($password);
        $object->setEmail($email);
        return $object;
    }
    
    /**
     * TODO: Function documentation fromDbArray
     *
     * @param array $dbArray
     * @return User
     *
     * @throws ValidationException
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public static function fromDbArray(array $dbArray) : User {
        $user = new self();
        $user->setId((int) $dbArray['user_id']);
        $user->setUsername($dbArray['username']);
        $user->setPassword($dbArray['password']);
        
        if (isset($dbArray['email'])) {
            $user->setEmail($dbArray['email']);
        }
        
        return $user;
    }
    
    /**
     * TODO: Function documentation setUsername
     *
     * @param string $username
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setUsername(string $username) : void {
        if (mb_strlen($username) > self::USERNAME_MAX_LENGTH) {
            throw new ValidationException("Please enter again the Username. Username must not be longer than " .
                                          self::USERNAME_MAX_LENGTH . " characters.");
        }
        $this->username = $username;
    }
    
    /**
     * TODO: Function documentation getUsername
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getUsername() : string {
        return $this->username;
    }
    
    /**
     * TODO: Function documentation setPassword
     *
     * @param string $password
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setPassword(string $password) : void {
        if (mb_strlen($password) > self::PASSWORD_MAX_LENGTH) {
            throw new ValidationException("Please enter a new Password. Password must not be longer than " .
                                          self::PASSWORD_MAX_LENGTH . " characters.");
        }
        $this->password = $password;
    }
    
    /**
     * TODO: Function documentation getPassword
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getPassword() : string {
        return $this->password;
    }
    
    /**
     * TODO: Function documentation getEmail
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getEmail() : string {
        return $this->email;
    }
    
    /**
     * TODO: Function documentation setEmail
     *
     * @param string $email
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setEmail(string $email) : void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email format.");
        }
        if (mb_strlen($email) > self::EMAIL_MAX_LENGTH) {
            throw new ValidationException("Please enter a new Email. Email must not be longer than " .
                                          self::EMAIL_MAX_LENGTH . " characters.");
        }
        $this->email = $email;
    }
    
    /**
     * TODO: Function documentation getCreatedAt
     * @return DateTime|null
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getCreatedAt() : ?DateTime {
        return $this->createdAt;
    }
    
    /**
     * TODO: Function documentation setCreatedAt
     *
     * @param DateTime|null $createdAt
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setCreatedAt(?DateTime $createdAt) : void {
        $this->createdAt = $createdAt;
    }
    
    /**
     * TODO: Function documentation getUpdatedAt
     * @return DateTime|null
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getUpdatedAt() : ?DateTime {
        return $this->updatedAt;
    }
    
    /**
     * TODO: Function documentation setUpdatedAt
     *
     * @param DateTime|null $updatedAt
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setUpdatedAt(?DateTime $updatedAt) : void {
        $this->updatedAt = $updatedAt;
    }
    
    /**
     * TODO: Function documentation getIsDeleted
     * @return bool
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getIsDeleted() : bool {
        return $this->isDeleted;
    }
    
    /**
     * TODO: Function documentation setIsDeleted
     *
     * @param bool $isDeleted
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setIsDeleted(bool $isDeleted) : void {
        $this->isDeleted = $isDeleted;
    }
    
    /**
     * TODO: Function documentation validateForUserCreate
     * @return bool
     *
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function validateForUserCreate() : bool {
        if (empty($this->username)) {
            throw new ValidationException("Please enter a Username.");
        }
        if (empty($this->password)) {
            throw new ValidationException("Please enter a Password.");
        }
        if (empty($this->email)) {
            throw new ValidationException("Please enter an Email.");
        }
        return true;
    }
    
    /**
     * TODO: Function documentation validateForUserDelete
     * @return bool
     *
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function validateForUserDelete() : bool {
        if (empty($this->username)) {
            throw new ValidationException("Please enter a Username.");
        }
        return true;
    }
    
    
    public function setUserGroupId(int $user_group_id) : void {
        $this->userGroupId = $user_group_id;
    }
    
}