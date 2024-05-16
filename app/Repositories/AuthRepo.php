<?php

namespace app\Repositories;

class AuthRepo extends BaseRepository
{
    public function insertUser(array $formData): int
    {
        $password = password_hash(password: $formData['password'], algo: PASSWORD_DEFAULT);
        $email = $this->sanitizeInput($formData["email"]);
        $username = $this->sanitizeInput($formData["username"]);

        $stmt = $this->prepareAndExecuteQuery(query: "INSERT INTO users (email, password, username) VALUES (?, ?, ?)", types: 'sss', params: [$email, $password, $username], shouldReturn: true);
        return $stmt->insert_id;
    }

    public function getUserByEmail(string $email): false | \mysqli_result
    {
        $stmt = $this->prepareAndExecuteQuery(query: "SELECT * FROM users WHERE email = ?", types: "s", params: [$email], shouldReturn: true);
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