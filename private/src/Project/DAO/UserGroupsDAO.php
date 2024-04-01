<?php
/**
 * 420DW3_07278_Project UserGroupsDAO.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-24
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\DAO;

use PDO;
use Project\DTO\UserGroup;
use Teacher\GivenCode\Abstracts\AbstractDTO;
use Teacher\GivenCode\Abstracts\IDAO;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Services\DBConnectionService;

class UserGroupsDAO implements IDAO {
    
    private const GET_QUERY_SELECT = "SELECT * FROM `" . UserGroup::TABLE_NAME . "` WHERE `user_group_id` = :user_group_id;";
    private const CREATE_QUERY_INSERT = "INSERT INTO `" . UserGroup::TABLE_NAME . "` (`group_name`, `group_description`) VALUES (:group_name, :group_description);";
    private const UPDATE_QUERY = "UPDATE `" . UserGroup::TABLE_NAME . "` SET `group_name` = :group_name, `group_description` = :group_description WHERE `user_group_id` = :user_group_id;";
    private const DELETE_QUERY = "DELETE FROM `" . UserGroup::TABLE_NAME . "` WHERE `user_group_id` = :user_group_id;";
    
    public function __construct() {}
    
    /**
     * TODO: Function documentation create
     *
     * @param object $dto
     * @return UserGroup
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function create(object $dto) : UserGroup {
        if (!($dto instanceof UserGroup)) {
            throw new RuntimeException("Passed object is not an instance of UserGroup.");
        }
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::CREATE_QUERY_INSERT);
        $statement->bindValue(":group_name", $dto->getGroupName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $dto->getDescription(), PDO::PARAM_STR);
        $statement->execute();
        $new_id = (int) $connection->lastInsertId();
        $new_group = $this->getById($new_id);
        if ($new_group === null) {
            throw new RuntimeException("Unable to retrieve the user group after creation. Group ID: {$new_id}");
        }
        return $new_group;
    }
    
    /**
     * TODO: Function documentation deleteById
     *
     * @param int $id
     * @return void
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function deleteById(int $id) : void {
        $connection = DBConnectionService::getConnection();
        
        if($this->getById($id) === null) {
            throw new RuntimeException("No record found for user_group_id# [$id].");
        }
        
        $statement = $connection->prepare(self::DELETE_QUERY);
        $statement->bindValue(":id", $id, PDO::PARAM_INT);
        $statement->execute();
        
    }
    
    /**
     * TODO: Function documentation delete
     *
     * @param object $dto
     * @return void
     * @throws RuntimeException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function delete(object $dto) : void {
        if (!$dto instanceof UserGroup) {
            throw new RuntimeException("Passed object is not an instance of UserGroup.");
        }
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::DELETE_QUERY);
        $statement->bindValue(":user_group_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
    }
    
    /**
     * TODO: Function documentation update
     *
     * @param AbstractDTO $dto
     * @return AbstractDTO
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function update(AbstractDTO $dto) : AbstractDTO {
        if (!($dto instanceof UserGroup)) {
            throw new RuntimeException("Passed object is not an instance of UserGroup.");
        }
        $dto->validateForDbUpdate();
        
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::UPDATE_QUERY);
        $statement->bindValue(":group_name", $dto->getGroupName(), PDO::PARAM_STR);
        $statement->bindValue(":description", $dto->getDescription(), PDO::PARAM_STR);
        $statement->bindValue(":user_group_id", $dto->getId(), PDO::PARAM_INT);
        $statement->execute();
        
        $updated_group = $this->getById($dto->getId());
        if ($updated_group === null) {
            throw new RuntimeException("Unable to retrieve the user group after update. Group ID: " . $dto->getId());
        }
        
        return $updated_group;
    }
    
    /**
     * TODO: Function documentation getById
     *
     * @param int $id
     * @return UserGroup|null
     * @throws RuntimeException
     * @throws \Teacher\GivenCode\Exceptions\ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getById(int $id) : ?UserGroup {
        $connection = DBConnectionService::getConnection();
        $statement = $connection->prepare(self::GET_QUERY_SELECT);
        $statement->bindValue(":user_group_id", $id, PDO::PARAM_INT);
        $statement->execute();
        
        $array = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$array) {
            throw new RuntimeException("No record found for user_group_id# [$id].");
        }
        return UserGroup::fromDbArray($array);
    }
    
    
}