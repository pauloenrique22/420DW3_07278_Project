<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project UserDAO.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-24
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\DAO;

use PDO;
use Project\DTO\User;
use Teacher\GivenCode\Abstracts\AbstractDTO;
use Teacher\GivenCode\Abstracts\IDAO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

class UserDAO implements IDAO {
    
    private const GET_QUERY_SELECT = "SELECT * FROM `" . User::TABLE_NAME . "` WHERE `user_id` = :user_id;";
    private const CREATE_QUERY_INSERT = "INSERT INTO `" . User::TABLE_NAME .
    "` (`username`, `password`, `email`,`user_group_id`, `is_deleted`) VALUES (:username, :password, :email, :group_id);";
    private const UPDATE_QUERY = "UPDATE `" . User::TABLE_NAME .
    "` SET `user_password` = :password, `email` = :email, `group_id = :group_id` WHERE `user_id` = :user_id;";
    private const DELETE_QUERY = "DELETE FROM `" . User::TABLE_NAME . "` WHERE `user_id` = :user_id;";
    
    public function __construct() {}
    
    /**
     * {@inheritDoc}
     * Retrieves a record of a certain DTO entity from the database and returns
     * an appropriate DTO object instance.
     *
     * @param int $id The identifier value of the record to obtain.
     * @return AbstractDTO|null The created object DTO instance or null if no record was found for the specified id.
     *
     * @throws RuntimeException
     * @author Marc-Eric Boury
     * @since  2024-03-17
     */
    public function getById(int $id, bool $includeDeleted = false) : ?User {
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::GET_QUERY_SELECT);
        $statement->bindValue(":user_id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        $array = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$array) {
            throw new RuntimeException("No record found for user_id# [$id].");
        }
        return User::fromDbArray($array);
    }
    
    /**
     * {@inheritDoc}
     * Deletes the record of a certain DTO entity in the database based on its identifier.
     *
     * @param int $id The identifier of the DTO entity to delete
     * @return void
     *
     * @throws RuntimeException
     * @author Marc-Eric Boury
     * @since  2024-03-17
     */
    public function deleteById(int $id, bool $realDeletes = false) : void {
        $connection = DBConnectionService::getConnection();
        
        if ($realDeletes) {
            $statement = $connection->prepare(self::DELETE_QUERY);
        } else {
            $statement = $connection->prepare("UPDATE `" . User::TABLE_NAME . "` SET `is_deleted` = TRUE WHERE `user_id` = :id;");
        }
        
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        // verify that the user has indeed been deleted.
        if ($realDeletes) {
            $deleted_user = $this->getById($id);
            if ($deleted_user !== null) {
                // If the user can still be found, the deletion didn't work as expected.
                throw new RuntimeException("Failed to delete the user. User ID: " . $id);
            }
        }
    }
    
    /**
     * {@inheritDoc}
     * Creates a record for a certain DTO entity in the database.
     * Returns an updated appropriate DTO object instance.
     *
     * @param AbstractDTO $dto The {@see AbstractDTO} instance to create a record of.
     * @return AbstractDTO An updated {@see AbstractDTO} instance.
     *
     * @throws RuntimeException
     * @author Marc-Eric Boury
     * @since  2024-03-17
     */
    public function create(object $dto) : User {
        if (!($dto instanceof User)) {
            throw new RuntimeException("Passed object is not an instance of User.");
        }
        $dto->validateForDbCreation();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::CREATE_QUERY_INSERT);
        $statement->bindValue(":username", $dto->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(":password", $dto->getPassword(), PDO::PARAM_STR);
        $statement->bindValue(":email", $dto->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(":group_id", $dto->getGroupId(), PDO::PARAM_STR);
        $statement->execute();
        
        $new_id = (int) $connection->lastInsertId();
        $new_user = $this->getById($new_id);
        if ($new_user === null) {
            // Handle the unexpected case where the user could not be retrieved after insertion.
            throw new RuntimeException("Unable to retrieve the user after creation. User ID: {$new_id}");
        }
        
        return $new_user;
    }
    
    /**
     * {@inheritDoc}
     * Updates the record of a certain DTO entity in the database.
     * Returns an updated appropriate DTO object instance.
     *
     * @param AbstractDTO $dto The {@see AbstractDTO} instance to update the record of.
     * @return AbstractDTO An updated {@see AbstractDTO} instance.
     *
     * @throws RuntimeException
     * @author Marc-Eric Boury
     * @since  2024-03-17
     */
    public function update(object $dto) : User {
        if (!($dto instanceof User)) {
            throw new RuntimeException("Passed object is not an instance of User.");
        }
        $dto->validateForDbUpdate();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::UPDATE_QUERY);
        $statement->bindValue(":username", $dto->getUsername(), PDO::PARAM_STR);
        $statement->bindValue(":password", $dto->getPassword(), PDO::PARAM_STR);
        $statement->bindValue(":email", $dto->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(":group_id", $dto->getGroupId(), PDO::PARAM_STR);
        $statement->bindValue(":user_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
        
        // fetch the user to ensure the update was successful
        $updated_user = $this->getById($dto->getId());
        if ($updated_user === null) {
            // in case where the user could not be retrieved after updating
            throw new RuntimeException("Unable to retrieve the user after update. User ID: " . $dto->getId());
        }
        
        return $updated_user;
    }
    
    /**
     * {@inheritDoc}
     * Deletes the record of a certain DTO entity in the database.
     *
     * @param AbstractDTO $dto The {@see AbstractDTO} instance to delete the record of.
     * @return void
     *
     * @throws RuntimeException
     * @author Marc-Eric Boury
     * @since  2024-03-17
     */
    public function delete(object $dto, bool $realDeletes = false) : void {
        if (!($dto instanceof User)) {
            throw new RuntimeException("Passed object is not an instance of User.");
        }
        $dto->validateForDbDelete();
        
        $connection = DBConnectionService::getConnection();
        
        if ($realDeletes) {
            $statement = $connection->prepare(self::DELETE_QUERY);
        } else {
            $statement = $connection->prepare("UPDATE `" . User::TABLE_NAME . "` SET `is_deleted` = TRUE WHERE `user_id` = :user_id;");
        }
        
        $statement->bindValue(":user_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
        
        if ($realDeletes) {
            $deleted_user = $this->getById($dto->getId());
            if ($deleted_user !== null) {
                throw new RuntimeException("Failed to delete the user. User ID: " . $dto->getId());
            }
        }
    }
}