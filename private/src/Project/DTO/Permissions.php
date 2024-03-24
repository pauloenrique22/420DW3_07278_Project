<?php
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

class Permissions extends AbstractDTO{
    
    public const TABLE_NAME = "Permissions";
    
    
    public function getDatabaseTableName() : string {
        return self::TABLE_NAME;
    }
}