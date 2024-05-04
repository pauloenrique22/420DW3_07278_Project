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

use Teacher\GivenCode\Domain\WebpageRoute;
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
        } catch (RequestException $exception) {
            foreach ($exception->getHttpHeaders() as $header_name => $header_value) {
                header("$header_name: $header_value");
            }
            echo $exception->getMessage();
        } catch (ValidationException $exception) {
            http_response_code(400);
            echo $exception->getMessage();
        } catch (\Throwable $exception) {
            http_response_code(500);
            echo $exception->getMessage();
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