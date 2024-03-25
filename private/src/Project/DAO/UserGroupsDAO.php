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
    
    public function create(AbstractDTO $dto) : AbstractDTO {
        // TODO: Implement create() method.
        return False;
    }
    public function deleteById(int $id) : void {
        // TODO: Implement deleteById() method.
    }
    
    public function getById(int $id) : ?AbstractDTO {
        // TODO: Implement getById() method.
        return False;
    }
    
    public function delete(AbstractDTO $dto) : void {
        // TODO: Implement delete() method.
    }
    
    public function update(AbstractDTO $dto) : AbstractDTO {
        // TODO: Implement update() method.
        return False;
    }
    
}