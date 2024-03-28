<?php
/**
 * 420DW3_07278_Project UserGroup.php
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

class UserGroup extends AbstractDTO {
    
    public const TABLE_NAME = "User_Groups";
    
    private const GROUP_NAME_MAX_LENGTH = 30;
    private const GROUP_DESCRIPTION_MAX_LENGTH = 50;
    
    private string $groupName;
    private string $groupDescription;
    private ?DateTime $createdAt;
    private ?DateTime $updatedAt;
    private bool $isDeleted;
    
    
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
    
    protected function __construct() {
        parent::__construct();
    }
    
    /**
     * TODO: Function documentation constructorFromValues
     *
     * @param string $groupName
     * @param string $groupDescription
     * @return UserGroup
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public static function constructorFromValues(string $groupName, string $groupDescription) : UserGroup {
        $object = new self();
        $object->setGroupName($groupName);
        $object->setDescription($groupDescription);
        return $object;
    }
    
    /**
     * TODO: Function documentation fromDbArray
     *
     * @param array $dbAssocArray
     * @return UserGroup
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public static function fromDbArray(array $dbAssocArray) : UserGroup {
        $object = new self();
        $object->setGroupName($dbAssocArray['group_name']);
        $object->setDescription($dbAssocArray['group_description']);
        $object->setCreatedAt(
            DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["date_created"])
        );
        $object->setUpdatedAt(
            DateTime::createFromFormat(DB_DATETIME_FORMAT, $dbAssocArray["date_modified"])
        );
        $object->setIsDeleted($dbAssocArray['is_deleted']);
        return $object;
    }
    
    /**
     * TODO: Function documentation setGroupName
     *
     * @param string $groupName
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setGroupName(string $groupName) : void {
        if (mb_strlen($groupName) > self::GROUP_NAME_MAX_LENGTH) {
            throw new ValidationException("Please enter again the Groupe name. Group name must not be longer than " . self::GROUP_NAME_MAX_LENGTH . " characters.");
        }
        $this->groupName = $groupName;
    }
    
    
    /**
     * TODO: Function documentation getGroupName
     * @return string
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getGroupName() : string {
        return $this->groupName;
    }
    
    /**
     * TODO: Function documentation setDescription
     *
     * @param string $description
     * @return void
     * @throws ValidationException
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setDescription(string $groupDescription) : void {
        if (mb_strlen($groupDescription) > self::GROUP_DESCRIPTION_MAX_LENGTH) {
            throw new ValidationException("Please enter again the Description. Description must not be longer than " . self::GROUP_DESCRIPTION_MAX_LENGTH . " characters.");
        }
        $this->GroupDescription = $groupDescription;
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
    
    public function getCreatedAt() : ?DateTime {
        return $this->createdAt;
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
     * TODO: Function documentation setIsDeleted
     *
     * @param bool $isDeleted
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function setIsDeleted(bool $isDeleted): void {
        $this->isDeleted = $isDeleted;
    }
    
    
    /**
     * TODO: Function documentation getIsDeleted
     * @return bool
     *
     * @author PE-Oliver89
     * @since  2024-03-28
     */
    public function getIsDeleted(): bool {
        return $this->isDeleted;
    }
    
    
}