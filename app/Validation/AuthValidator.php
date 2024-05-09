<?php

namespace app\Validation;

use app\Repositories\AuthRepo;

class AuthValidator
{
    private array $validationErrors;
    private const REGISTER_VALIDATION_RULES = __DIR__ . '/../../config/registerValidationConfig.php';
    private const LOGIN_VALIDATION_RULES = __DIR__ . '/../../config/loginValidationConfig.php';

    public function validateRegister(array $formData): bool
    {
        $validationRules = require self::REGISTER_VALIDATION_RULES;

        foreach ($validationRules as $key => $value) {
            $this->validateField(formData: $formData, fieldName: $key, fieldInfo: $value);
        }

        $this->validateEmail(email: $formData['email']);
        $this->validatePassword(password: $formData['password'], confirmPassword: $formData['confirm_password']);

        if (isset($this->validationErrors)) return false;
        return true;
    }

    public function validateLogin(array $formData): bool
    {
        $validationRules = require self::LOGIN_VALIDATION_RULES;

        foreach ($validationRules as $key => $value) {
            $this->validateField(formData: $formData, fieldName: $key, fieldInfo: $value);
        }

        if (isset($this->validationErrors)) return false;
        return true;
    }

    public function getValidationErrors(): array
    {
        return $this->validationErrors;
    }

    public function validateField(array $formData, string $fieldName, array $fieldInfo): void
    {
        if (empty($formData[$fieldName]) && $fieldInfo['required']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'] . ' is required';
            return;
        }

        $inputValue = trim($formData[$fieldName]);

        if (isset($fieldInfo['min_length']) && strlen($inputValue) < $fieldInfo['min_length']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'] . 'must be minimum ' . $fieldInfo['min_length'] . "characters long";
        }

        if (isset($fieldInfo['max_length']) && strlen($inputValue) > $fieldInfo['max_length']) {
            $this->validationErrors[$fieldName] = $fieldInfo['label'] . 'can be ' . $fieldInfo['max_length'] . "characters long";
        }

        if ($fieldInfo['unique']) {
            $authRepo = new AuthRepo();
            $userExists = $authRepo->userExists($inputValue);

            if ($userExists) {
                $this->validationErrors[$fieldName] = $fieldInfo['label'] . ' already exits.';
            }
        }
    }

    private function validateEmail(string $email): void
    {
        if (!filter_var(value:$email, filter: FILTER_VALIDATE_EMAIL)) {
            $this->validationErrors['email'] = "Invalid email address.";
        }
    }

    private function validatePassword(string $password, string $confirmPassword): void
    {
        if ($password !== $confirmPassword) {
            $this->validationErrors["password"] = "Passwords do not match.";
        }
    }
}