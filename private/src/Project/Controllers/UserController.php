<?php
/**
 * 420DW3_07278_Project UserController.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */

namespace Project\Controllers;

use Project\Services\UserService;
use Teacher\GivenCode\Abstracts\AbstractController;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\RuntimeException;
use Teacher\GivenCode\Exceptions\ValidationException;

class UserController extends AbstractController {
    private UserService $userService;
    
    public function __construct() {
        parent::__construct();
        $this->userService = new UserService();
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
        if (empty($_REQUEST["userId"])) {
            throw new RequestException("Bad request: required parameter [userId] not found in the request.", 400);
        }
        if (!is_numeric($_REQUEST["userId"])) {
            throw new RequestException("Bad request: parameter [userId] value [" . $_REQUEST["userId"] .
                                       "] is not numeric.", 400);
        }
        $userId = (int) $_REQUEST["userId"];
        $user = $this->userService->getUserById($userId);
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode($user);
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
        if (!$this->validateUserData($data)) {
            throw new RequestException("Bad request: Missing or invalid fields.", 400);
        }
        
        if (isset($data['password'])) {
            $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            throw new RequestException("Password is required.", 400);
        }
        
        try {
            $created_user = $this->userService->createUser($data['username'], $hashed_password, $data['email']);
        } catch (ValidationException $exception) {
            throw new RequestException("Validation error: " . $exception->getMessage(), 422);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode([
                             'message' => 'User created successfully',
                             'userId' => $created_user->getId()
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
        $data = $_REQUEST;
        
        if (empty($data['userId'])) {
            throw new RequestException("User ID is required for updating.", 400);
        }
        
        $userId = (int) $data['userId'];
        
        if (!$this->validateUserData($data)) {
            throw new RequestException("Bad request: Missing or invalid fields.", 400);
        }
        
        if (!empty($data['password'])) {
            $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);
        } else {
            $hashed_password = null;
        }
        
        try {
            $updated_user =
                $this->userService->updateUser($userId, $data['username'], $hashed_password, $data['email']);
        } catch (ValidationException $exception) {
            throw new RequestException("Validation error: " . $exception->getMessage(), 422);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        header("Content-Type: application/json;charset=UTF-8");
        echo json_encode([
                             'message' => 'User updated successfully',
                             'userId' => $updated_user->getId()
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
        
        $userId = $_REQUEST['userId'] ?? null;
        if (is_null($userId) || !is_numeric($userId)) {
            throw new RequestException("Bad request: User ID is missing or invalid.", 400);
        }
        
        $userId = (int) $userId;
        try {
            $user = $this->userService->getUserById($userId);
            if (!$user) {
                throw new RequestException("User not found.", 404);
            }
            
            $hardDelete = false;
            $this->userService->deleteUser($userId, $hardDelete);
            
            header("Content-Type: application/json;charset=UTF-8");
            echo json_encode(['message' => 'User deleted successfully']);
        } catch (RequestException $exception) {
            http_response_code($exception->getHttpResponseCode());
            echo json_encode(['error' => $exception->getMessage()]);
        } catch (RuntimeException $exception) {
            throw new RequestException("Server error: " . $exception->getMessage(), 500);
        }
        
        ob_end_flush();
    }
    
    /**
     * TODO: Function documentation validateUserData
     *
     * @param $data
     * @return array
     *
     * @author PE-Oliver89
     * @since  2024-03-31
     */
    private function validateUserData($data) : array {

        if (empty($data['username']) || empty($data['password']) || empty($data['email'])) {
            return ['success' => false, 'message' => 'Username, password, and email are required.'];
        }
        if (!ctype_alnum($data['username'])) {
            return ['success' => false, 'message' => 'Username must contain only alphanumeric characters.'];
        }
        
        if ((strlen($data['username']) < 3) || (strlen($data['username']) > 30)) {
            return ['success' => false, 'message' => 'Username must be between 3 and 30 characters.'];
        }
        
        if (strlen($data['password']) < 8) {
            return ['success' => false, 'message' => 'Password must be at least 8 characters.'];
        }
        
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format.'];
        }
        return ['success' => true, 'message' => 'Validation successful.'];
    }
}