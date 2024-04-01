<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project UserGroupController.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Controllers;

use Project\Services\UserGroupService;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

class UserGroupController extends AbstractController {
    private UserGroupService $userGroupService;
    
    public function __construct() {
        parent::__construct();
        $this->userGroupService = new UserGroupService();
    }
    
    /**
     * TODO: Function documentation get
     * @return void
     *
     * @throws RequestException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function get() : void {
        ob_start();
        $groupId = $_REQUEST['groupId'] ?? null;
        
        if (is_null($groupId) || !is_numeric($groupId)) {
            throw new RequestException("Bad request: Group ID is missing or invalid.", 400);
        }
        
        $group = $this->userGroupService->getUserGroupById((int) $groupId);
        if (!$group) {
            throw new RequestException("Group not found.", 404);
        }
        
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode($group);
        ob_end_flush();
    }
    
    /**
     * TODO: Function documentation post
     * @return void
     *
     * @throws RequestException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function post() : void {
        ob_start();
        
        $data = $_REQUEST;
        if (!$this->validateUserGroupData($data)) {
            throw new RequestException("Bad request: Missing or invalid fields.", 400);
        }
        
        try {
            $created_group = $this->userGroupService->createUserGroup($data['groupName'], $data['description']);
        } catch (ValidationException $exception) {
            throw new RequestException("Validation error: " . $exception->getMessage(), 422);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode([
                             'message' => 'User group created successfully',
                             'groupId' => $created_group->getId()
                         ]);
        
        ob_end_flush();
    }
    
    /**
     * TODO: Function documentation put
     * @return void
     *
     * @throws RequestException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function put() : void {
        ob_start();
        
        $data = $_REQUEST;
        if (empty($data['userGroupId'])) {
            throw new RequestException("User group ID is required for updating.", 400);
        }
        
        $userGroupId = (int) $data['userGroupId'];
        
        $validationResult = $this->validateUserGroupData($data);
        if (!$validationResult['success']) {
            throw new RequestException($validationResult['message'], 400);
        }
        
        try {
            $updatedGroup =
                $this->userGroupService->updateUserGroup($userGroupId, $data['groupName'], $data['description'] ?? '');
        } catch (ValidationException $exception) {
            throw new RequestException("Validation error: " . $exception->getMessage(), 422);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode([
                             'message' => 'User group updated successfully',
                             'userGroupId' => $updatedGroup->getId()
                         ]);
        
        ob_end_flush();
    }
    
    /**
     * TODO: Function documentation delete
     * @return void
     *
     * @throws RequestException
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    public function delete() : void {
        ob_start();
        $userGroupId = $_REQUEST['userGroupId'] ?? null;
        
        if (is_null($userGroupId) || !is_numeric($userGroupId)) {
            throw new RequestException("Bad request: User group ID is missing or invalid.", 400);
        }
        $userGroupId = (int) $userGroupId;
        
        try {
            $userGroup = $this->userGroupService->getUserGroupById($userGroupId);
            if (!$userGroup) {
                throw new RequestException("User group not found.", 404);
            }
            
            $hardDelete = false; //
            $this->userGroupService->deleteUserGroup($userGroupId, $hardDelete);
            
            header("Content-Type: application/json;charset=UTF-8");
            echo json_encode(['message' => 'User group deleted successfully']);
        } catch (RequestException $exception) {
            http_response_code($exception->getHttpResponseCode());
            echo json_encode(['error' => $exception->getMessage()]);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        ob_end_flush();
    }
    
    /**
     * TODO: Function documentation validateUserGroupData
     *
     * @param $data
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    private function validateUserGroupData($data) : array {
        if (empty($data['groupName'])) {
            return ['success' => false, 'message' => 'Group name is required.'];
        }
        if ((strlen($data['groupName']) < 3) || (strlen($data['groupName']) > 20)) {
            return ['success' => false, 'message' => 'Group name must be between 3 and 20 characters.'];
        }
        if (isset($data['description']) && (strlen($data['description']) > 70)) {
            return ['success' => false, 'message' => 'Description must not exceed 100 characters.'];
        }
        // If all checks pass
        return ['success' => true, 'message' => 'Validation successful.'];
    }
    
}