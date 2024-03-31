<?php
/**
 * 420DW3_07278_Project UserPermissionEnum.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-31
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Ennumerations;

enum UserPermissionEnum: string {
    
    case LOGIN_ALLOWED = 'Login Allowed';
    case MANAGE_PERMISSIONS = 'Manage Permissions';
    case MANAGE_USERGROUPS = 'Manage User Groups';
    case MANAGE_USERS = 'Manage Users';
    
    /**
     * TODO: Function documentation fromString
     *
     * @param string $value
     * @return self
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public static function fromString(string $value) : self {
        return self::tryFrom(ucfirst(strtolower($value))) ?? throw new \InvalidArgumentException("Invalid permission name");
    }
}