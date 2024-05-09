<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Controllers\AuthController;
use app\Controllers\WorkoutController;
use app\Support\Session;
use app\Support\Router;

$viewPath = "../view";
$baseUrl = "/workout-logger";

Session::start();
$router = new Router();

$router->get(path: $baseUrl . "/", handler: fn() => require_once $viewPath . '/home.php');
$router->get(path: $baseUrl . "/register", handler: fn() => require_once $viewPath . '/auth/register.php');
$router->get(path: $baseUrl . "/login", handler: fn() => require_once $viewPath . '/auth/login.php');
$router->get(path: $baseUrl . "/workout", handler: fn() => require_once $viewPath . '/workout.php');

$router->post(path: $baseUrl . "/register/submit", handler: AuthController::class . '::handleRegistration');
$router->post(path: $baseUrl . "/login/submit", handler: AuthController::class . '::handleLogin');
$router->post(path: $baseUrl . "/logout", handler: AuthController::class . '::handleLogout');
$router->post(path: $baseUrl . "/workout-plan/submit", handler: WorkoutController::class . '::handleAddWorkoutPlan');

$router->addNotFoundHandler(fn() => require_once $viewPath . '/404.php');
$router->run();