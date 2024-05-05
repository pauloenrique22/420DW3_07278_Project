<?php
/**
 * 420DW3_07278_Project UserGroupService.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

use Project\DAO\UserGroupsDAO;
use Project\DTO\UserGroups;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

class UserGroupService implements IService {
    private UserGroupDAO $userGroupDao;
    
    public function __construct() {
        $this->userGroupDao = new UserGroupDAO();
    }
    
    /**
     * TODO: Function documentation createUserGroup
     *
     * @param string $group_name
     * @param string $description
     * @return UserGroup
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function createUserGroup(string $group_name, string $description) : UserGroup {
        $user_group = new UserGroup();
        $user_group->setGroupName($group_name);
        $user_group->setDescription($description);
        return $this->userGroupDao->create($user_group);
    }
    
    /**
     * TODO: Function documentation getUserGroupById
     *
     * @param int $id
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getUserGroupById(int $id) : ?UserGroup {
        return $this->userGroupDao->getById($id);
    }
    
    /**
     * TODO: Function documentation getAllUserGroups
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAllUserGroups() : array {
        return $this->userGroupDao->getAll();
    }
    
    /**
     * TODO: Function documentation updateUserGroup
     *
     * @param int    $id
     * @param string $groupName
     * @param string $description
     * @return UserGroup
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function updateUserGroup(int $id, string $groupName, string $description) : UserGroup {
        $user_group = $this->userGroupDao->getById($id);
        $user_group->setGroupName($groupName);
        $user_group->setDescription($description);
        return $this->userGroupDao->update($user_group);
    }
    
    /**
     * TODO: Function documentation deleteUserGroup
     *
     * @param int  $id
     * @param bool $hardDelete
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function deleteUserGroup(int $id, bool $hardDelete = false) : void {
        $this->userGroupDao->deleteById($id, $hardDelete);
    }
    
}
