<?php

namespace app\Controllers;

class BaseController
{
    protected function redirect(string $path): void
    {
        header("Location: /workout-logger" . $path);
        exit();
    }

    protected function redirectToNotFound(): void
    {
        http_response_code(404);
        require_once __DIR__ . "/../../view/404.php";
        exit();
    }
}