<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project PermissionDAO.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-24
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\DAO;

use PDO;
use PDOException;
use Project\DTO\Permissions;
use Teacher\GivenCode\Abstracts\AbstractDTO;
use Teacher\GivenCode\Abstracts\IDAO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

class PermissionDAO implements IDAO {
    
    private const GET_QUERY_SELECT = "SELECT * FROM `" . Permissions::TABLE_NAME .
    "` WHERE `permissions_id` = :permission_id;";
    
    private const CREATE_QUERY_INSERT = "INSERT INTO `" . Permissions::TABLE_NAME .
    "` (`permission_name`, `permission_description`, `user_group_id`) VALUES (:permission_name, :permission_description, :user_group_id);";
    private const UPDATE_QUERY = "UPDATE `" . Permissions::TABLE_NAME .
    "` SET `permission_name` = :permission_name, `permission_description` = :permission_description, `user_group_id` = :user_group_id WHERE `permission_id` = :permission_id;";
    private const DELETE_QUERY = "DELETE FROM `" . Permissions::TABLE_NAME .
    "` WHERE `permissions_id` = :permission_id;";
    
    private PDO $connection;
    
    /**
     * @param PDO $connection
     * @throws RuntimeException
     */
    public function __construct(PDO $connection) {
        $this->connection = DBConnectionService::getConnection();
    }
    
    /**
     * TODO: Function documentation getById
     *
     * @param int $id
     * @return Permissions|null
     * @throws RuntimeException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     *
     */
    public function getById(int $id) : ?Permissions {
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::GET_QUERY_SELECT);
        $statement->bindValue(":permission_id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        $array = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$array) {
            throw new RuntimeException("No record found for permission_id# [$id].");
        }
        return Permissions::fromDbArray($array);
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
    public function create(object $dto) : Permissions {
        if (!($dto instanceof Permissions)) {
            throw new RuntimeException("Passed object is not an instance of Permission.");
        }
        //$dto->validateForDbCreation();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::CREATE_QUERY_INSERT);
        $statement->bindValue(":permission_name", $dto->getPermissionName(), PDO::PARAM_STR);
        $statement->bindValue(":permission_description", $dto->getPermissionDescription(), PDO::PARAM_STR);
        $statement->bindValue(":user_group_id", $dto->getUserGroupId(), PDO::PARAM_STR);
        $statement->execute();
        
        $new_id = (int) $connection->lastInsertId();
        return $this->getById($new_id);
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
        $statement = $connection->prepare(self::DELETE_QUERY);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
    }
    
    /**
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
        if (!($dto instanceof Permissions)) {
            throw new RuntimeException("Passed object is not an instance of Permission.");
        }
        $dto->validateForDbDelete();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::DELETE_QUERY);
        $statement->bindValue(":permission_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
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
    public function update(object $dto) : Permissions {
        if (!($dto instanceof Permissions)) {
            throw new RuntimeException("Passed object is not an instance of Permission.");
        }
        $dto->validateForDbUpdate();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::UPDATE_QUERY);
        $statement->bindValue(":permission_key", $dto->getPermissionKey(), PDO::PARAM_STR);
        $statement->bindValue(":name", $dto->getName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $dto->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(":permission_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
        
        return $this->getById($dto->getId());
    }
    
    /**
     * TODO: Function documentation getAll
     * @return array
     *
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAll() : array {
        $connection = DBConnectionService::getConnection();
        
        try {
            $statement = $connection->prepare("SELECT * FROM `" . Permissions::TABLE_NAME . "`;");
            $statement->execute();
            $array = $statement->fetchAll(PDO::FETCH_ASSOC);
            $permissions = [];
            
            foreach ($array as $row) {
                $permissions[] = Permissions::fromDbArray($row);
            }
            return $permissions;
        }catch (PDOException $e) {
            throw new RuntimeException("Error while fetching all permissions: " . $e->getMessage());
        }
    }
    
    /**
     * TODO: Function documentation getUserPermissions
     *
     * @param int $userId
     * @return array
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-05-01
     */
    public function getUserPermissions(int $userId) : array {
        $connection = DBConnectionService::getConnection();
        $query = "SELECT permissions_id FROM permissions
              JOIN user_groups ON permissions.user_group_id = user_groups.user_group_id
              JOIN users ON user_groups.user_group_id = users.user_group_id
              WHERE users.user_id = :inputUserId";
        
        try {
            $statement = $connection->prepare($query);
            $statement->bindValue(":inputUserId", $userId, PDO::PARAM_INT);
            $statement->execute();
            $array = $statement->fetchAll(PDO::FETCH_ASSOC);
            $permissions = [];
            
            foreach ($array as $row) {
                $permissions[] = Permissions::fromDbArray($row);
            }
            return $permissions;
        }catch (PDOException $exception) {
            throw new RuntimeException("Error while fetching all permissions: " . $exception->getMessage());
        }
    }
    
}