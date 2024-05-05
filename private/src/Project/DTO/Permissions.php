<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project Permissions.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-24
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\DTO;

use DateTime;
use JetBrains\PhpStorm\Pure;
use Teacher\GivenCode\Abstracts\AbstractDTO;
use Teacher\GivenCode\Exceptions\ValidationException;

class Permissions extends AbstractDTO {
    
    public const TABLE_NAME = "Permissions";
    private const PERMISSION_ID_MAX_LENGTH = 30;
    private const PERMISSION_NAME_MAX_LENGTH = 20;
    private const PERMISSION_DESCRIPTION_MAX_LENGTH = 50;
    
    /* Variables  */
    private int $permissionId;
    private string $permissionKey;
    private string $permissionName;
    private string $permissionDescription;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;
    
    /**
     * TODO: Function documentation getDatabaseTableName
     *
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-24
     */
    public function getDatabaseTableName() : string {
        return self::TABLE_NAME;
    }
    
    /**
     * TODO: Function documentation fromDbArray
     *
     * @param array $dbAssocArray
     * @return Permissions
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-27
     */
    public static function fromDbArray(array $dbAssocArray) : Permissions {
        $object = new self();
        $object->setPermissionId((int) $dbAssocArray['permission_id']);
        $object->setPermissionKey($dbAssocArray['permission_key']);
        $object->setPermissionName($dbAssocArray['permission_name']);
        $object->setPermissionDescription($dbAssocArray['permission_description']);
        /*$object->setCreatedAt(
            DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["date_created"])
        );
        $object->setUpdatedAt(
            DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["date_modified"])
        );*/
        return $object;
    }
    
    /**
     * TODO: Function documentation getPermissionId
     *
     * @author PE-Oliver89
     * @since  2024-05-04
     */
    public function getPermissionId() : int {
        return $this->permissionId;
    }
    
    
    /**
     * TODO: Function documentation setPermissionId
     *
     * @param int $id
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-05-05
     */
    public function setPermissionId(int $id) : void {
        $this->permissionId = $id;
    }
    
    /**
     * TODO: Function documentation getPermissionKey
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-27
     */
    public function getPermissionKey() : string {
        return $this->permissionKey;
    }
    
    /**
     * TODO: Function documentation setPermissionKey
     *
     * @author PE-Oliver89
     * @since  2024-03-27
     */
    public function setPermissionKey(string $permissionKey) : void {
        $this->permissionKey = $permissionKey;
    }
    
    /**
     * TODO: Function documentation getPermissionName
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-27
     */
    public function getPermissionName() : string {
        return $this->permissionName;
    }
    
    /**
     * TODO: Function documentation setPermissionName
     *
     * @param string $permissionName
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setPermissionName(string $permissionName) : void {
        if (mb_strlen($permissionName) > self::PERMISSION_NAME_MAX_LENGTH) {
            throw new ValidationException("Please enter again the permission name. Permission name must not be longer than " . self::PERMISSION_NAME_MAX_LENGTH . " characters.");
        }
        $this->permissionName = $permissionName;
    }
    
    /**
     * TODO: Function documentation getPermissionDescription
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getPermissionDescription() : string {
        return $this->permissionDescription;
    }
    
    /**
     * TODO: Function documentation setPermissionDescription
     *
     * @param string $permissionDescription
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setPermissionDescription(string $permissionDescription) : void {
        if (mb_strlen($permissionDescription) > self::PERMISSION_DESCRIPTION_MAX_LENGTH) {
            throw new ValidationException("Please enter again the description. Description must not be longer than " . self::PERMISSION_DESCRIPTION_MAX_LENGTH . " characters.");
        }
        $this->permissionDescription = $permissionDescription;
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
    
    
}
    
    
    