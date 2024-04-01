<?php
/**
 * 420DW3_07278_Project PermissionService.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */
declare(strict_types=1);

namespace Project\Services;

use Project\Ennumerations\UserPermissionEnum;
use Project\DAO\PermissionDAO;
use Project\DTO\Permissions;
use Teacher\GivenCode\Abstracts\IService;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

/**
 * Class PermissionService
 */

class PermissionService implements IService {
    
    private PermissionDAO $permissionDao;
    
    public function __construct() {
        $this->permissionDao = new PermissionDAO();
    }
    
    /**
     * TODO: Function documentation createPermission
     *
     * @param Permissions $permission
     * @return Permissions
     * @throws RuntimeException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function createPermission(Permissions $permission) : Permissions {
        return $this->permissionDao->create($permission);
    }
    
    /**
     * TODO: Function documentation getPermissionById
     *
     * @param int $id
     * @return Permissions|null
     * @throws RuntimeException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getPermissionById(int $id) : ?Permissions {
        return $this->permissionDao->getById($id);
    }
    
    /**
     * TODO: Function documentation getAllPermissions
     * @return array
     *
     * @throws RuntimeException
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function getAllPermissions() : array {
        return $this->permissionDao->getAll();
    }
    
    
}