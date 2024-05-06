<?php

namespace app\Support;

class Session
{
    public static function start(): void
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function userLogin(int $userId): void
    {
        if (!$userId) return;

        self::start();
        $_SESSION['user_id'] = $userId;
    }

    public static function isUserLoggedIn(): bool
    {
        self::start();
        return isset($_SESSION["user_id"]);
    }

    public static function userLogout(): void
    {
        self::start();
        session_unset();
    }
}