<?php
declare(strict_types=1);

/*
 * 420DW3_07278_Project index.php
 * 
 * @author Marc-Eric Boury (MEbou)
 * @since 2024-03-14
 * (c) Copyright 2024 Marc-Eric Boury 
 */
require_once 'private/helpers/autoloader.php';
require_once "private/helpers/init.php";

use Project\Application;
use Teacher\GivenCode\Domain\WebpageRoute;
use Teacher\GivenCode\Services\InternalRouter;
use Teacher\GivenCode\Exceptions\ValidationException;

/*
 * Student name: Paulo Enrique Oliveira Silva
 * Student number: 2311209
 */

Debug::$DEBUG_MODE = false;

// TODO @Students You should create your own 'application'-style class and use it here
$application = new Application();
$application->getRouter()->addRoute(new WebpageRoute("/", "Project/login.php"));
#$application->getRouter()->addRoute(new WebpageRoute("/index", "Project/login.php"));
#$application->getRouter()->addRoute(new WebpageRoute("/login", "Project/login.php"));
$application->run();

