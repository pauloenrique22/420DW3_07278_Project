<?php
/**
 * 420DW3_07278_Project UserService.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

use Project\DAO\UserGroupsDAO;
use Project\DTO\UserGroup;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

class UserService implements IService {
    
    private UserGroupsDAO $userGroupsDao;
    
    public function __construct() {
        $this->userGroupsDao = new UserGroupsDAO();
    }
    
    /**
     * TODO: Function documentation getAllUserGroup
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAllUserGroup() : array {
        return $this->userGroupsDao->getAll();
    }
    
    /**
     * TODO: Function documentation getUserGroupById
     *
     * @param int $id
     * @return UserGroup|null
     * @throws RuntimeException
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getUserGroupById(int $id) : ?UserGroup {
        return $this->userGroupsDao->getById($id);
    }
    
    /**
     * TODO: Function documentation createUserGroup
     *
     * @param UserGroup $userGroup
     * @return UserGroup
     * @throws RuntimeException
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function createUserGroup(string $groupName, string $description) : UserGroup {
        $user_group = new UserGroupDAO();
        $user_group->setGroupName($groupName);
        $user_group->setDescription($description);
        return $this->userGroupsDao->create($user_group);
    }
    
    /**
     * TODO: Function documentation updateUserGroup
     *
     * @param UserGroup $userGroup
     * @return UserGroup
     * @throws RuntimeException
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function updateUserGroup(UserGroup $userGroup) : UserGroup {
        return $this->userGroupsDao->update($userGroup);
    }
    
    
}
