<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\Controllers\{AuthController, WorkoutController};
use app\Support\{Session, Router};

$viewPath = "../view";
$baseUrl = "/workout-logger";

Session::start();
$router = new Router();

$router->get(path: $baseUrl . "/", handler: fn() => require_once $viewPath . '/home.php');
$router->get(path: $baseUrl . "/register", handler: fn() => require_once $viewPath . '/auth/register.php');
$router->get(path: $baseUrl . "/login", handler: fn() => require_once $viewPath . '/auth/login.php');
$router->post(path: $baseUrl . "/register/submit", handler: AuthController::class . '::handleRegistration');
$router->post(path: $baseUrl . "/login/submit", handler: AuthController::class . '::handleLogin');

if (Session::isUserLoggedIn()) {
    $router->get(path: $baseUrl . "/workout", handler: fn() => require_once $viewPath . '/workout.php');
    $router->get(path: $baseUrl . "/workout-plan", handler: WorkoutController::class . '::permalinkWorkoutPlan');
    $router->get(path: $baseUrl . "/workout-day", handler: WorkoutController::class . '::permalinkWorkoutDay');

    $router->post(path: $baseUrl . "/logout", handler: AuthController::class . '::handleLogout');
    $router->post(path: $baseUrl . "/workout-plan/submit", handler: WorkoutController::class . '::handleAddWorkoutPlan');
    $router->post(path: $baseUrl . "/workout-day/submit", handler: WorkoutController::class . '::handleAddWorkoutDay');
    $router->post(path: $baseUrl . "/exercise/submit", handler: WorkoutController::class . '::handleAddExercise');
    $router->post(path: $baseUrl . "/logs/submit", handler: WorkoutController::class . '::handleAddLog');

    $router->post(path: $baseUrl . "/workout-plan/remove", handler: WorkoutController::class . '::handleRemoveWorkoutPlan');
    $router->post(path: $baseUrl . "/workout-day/remove", handler: WorkoutController::class . '::handleRemoveWorkoutDay');
    $router->post(path: $baseUrl . "/exercise/remove", handler: WorkoutController::class . '::handleRemoveExercise');
    $router->post(path: $baseUrl . "/logs/remove", handler: WorkoutController::class . '::handleRemoveLog');

    $router->post(path: $baseUrl . "/workout-day/edit", handler: WorkoutController::class . '::handleEditWorkoutDay');
    $router->post(path: $baseUrl . "/exercise/edit", handler: WorkoutController::class . '::handleEditExercise');
}

$router->addNotFoundHandler(handler: fn() => require_once $viewPath . '/404.php');
$router->run();