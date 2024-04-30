<?php
declare(strict_types=1);
/**
 * 420DW3_07278_Project Application.php
 *
 * @author   PE-Oliver89
 * @since    2024-03-28
 * (c) Copyright 2024 Paulo Enrique Oliveira Silva
 */
namespace Project;

use Project\Ennumerations\UserPermissionEnum;
use Teacher\GivenCode\Exceptions\RequestException;
use Teacher\GivenCode\Exceptions\ValidationException;
use Teacher\GivenCode\Services\InternalRouter;

class Application {
    private InternalRouter $router;
    
    /**
     * Application constructor.
     */
    public function __construct() {
        $this->router = new InternalRouter();
    }
    
    /**
     * TODO: Function documentation run
     * @return void
     *
     * @author PE-Oliver89
     * @since  2024-04-29
     */
    public function run() : void {
        try {
            $this->router->route();
        } catch (RequestException $e) {
            http_response_code($e->getCode());
            echo $e->getMessage();
        } catch (ValidationException $e) {
            http_response_code(400);
            echo $e->getMessage();
        } catch (\Throwable $e) {
            http_response_code(500);
            echo $e->getMessage();
        }
    }
    
    /**
     * TODO: Function documentation getRouter
     * @return InternalRouter
     *
     * @author PE-Oliver89
     * @since  2024-04-29
     */
    public function getRouter() : InternalRouter {
        return $this->router;
    }
}