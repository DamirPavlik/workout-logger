<?php

namespace app\Repositories;

class AuthRepo extends BaseRepository
{
    public function insertUser(array $formData): int
    {
        $password = password_hash(password: $formData['password'], algo: PASSWORD_DEFAULT);
        $email = $this->dbConnection->real_escape_string($formData["email"]);
        $username = $this->dbConnection->real_escape_string($formData["username"]);

        $stmt = $this->dbConnection->prepare("INSERT INTO users (email, password, username) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $email, $password, $username);
        $stmt->execute();

        return $stmt->insert_id;
    }

    public function getUserByEmail(string $email)
    {
        $stmt = $this->dbConnection->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        return $stmt->get_result();
    }

    public function loginUser(string $email): array
    {
        return $this->getUserByEmail($email)->fetch_assoc();
    }

    public function userExists(string $email): bool
    {
        return $this->getUserByEmail($email)->num_rows !== 0;
    }
}