<?php

namespace app\Controllers;

use app\Models\AuthModel;
use app\Support\Session;
use app\Validation\AuthValidator;

class AuthController extends BaseController
{
    public function __construct(
        private readonly AuthModel $authModel = new AuthModel(),
        private readonly AuthValidator $authValidator = new AuthValidator()
    ) {}

    public function handleLogout(): void
    {
        if (!Session::isUserLoggedIn()) $this->redirectToNotFound();

        Session::userLogout();
        $this->redirect(path: '/register');
    }

    public function handleRegistration(array $params = []): void
    {
        $isValid = $this->authValidator->validateRegister($params);

        if (!$isValid) {
            $_SESSION['registerErrors'] = $this->authValidator->getValidationErrors();
            $_SESSION['registrationFormData'] = $_POST;
            $this->redirect('/register');
        }

        unset($_SESSION['registrationFormData']);
        $this->authModel->register($_POST);
        $this->redirect(path: '/');
    }

    public function handleLogin(array $params = []): void
    {
        $isValid = $this->authValidator->validateLogin($params);

        if (!$isValid) {
            $_SESSION['validationErrors'] = $this->authValidator->getValidationErrors();
            $_SESSION['loginFormData'] = $_POST;
            $this->redirect('/login');
        }

        unset($_SESSION['loginFormData']);
        $login = $this->authModel->login(email: $params['email'], password: $params['password']);
        if (!$login) {
            $_SESSION['validationErrors'] = ["password" => "User does not exist"] ;
            $this->redirect(path: '/login');

        }
        $this->redirect(path: '/');
    }
}