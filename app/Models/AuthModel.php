<?php

namespace app\Models;

use app\Repositories\AuthRepo;
use app\Support\Session;

class AuthModel
{
    public function __construct(private readonly AuthRepo $authRepo = new AuthRepo()) {}

    public function register(array $formData): void
    {
        if ($this->authRepo->userExists($formData['email'])) {
            return;
        }
        $userId = $this->authRepo->insertUser($formData);
        Session::userLogin($userId);
    }

    public function login(string $email, string $password): bool
    {
        if ($this->authRepo->userExists($email)) return false;

        $user = $this->authRepo->loginUser($email);

        if (!password_verify($password, $user['password'])) return false;

        Session::userLogin($user['id']);
        return true;
    }
}