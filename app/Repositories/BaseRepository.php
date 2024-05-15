<?php

namespace app\Repositories;

use database\Database;
use Exception;
use mysqli_stmt;
use ReflectionClass;
use ReflectionException;

class BaseRepository
{
    protected \mysqli $dbConnection;

    public function __construct()
    {
        $db = new Database();
        $this->dbConnection = $db->getConnection();
    }

    public function sanitizeInput(string | int $input): string
    {
        return $this->dbConnection->real_escape_string($input);
    }

    public static function getUserId(): int | null
    {
        return $_SESSION['user_id'] ?? null;
    }

    public function prepareAndExecuteQuery(string $query, string $types, array $params, bool $shouldReturn): mysqli_stmt|null
    {
        $stmt = $this->dbConnection->prepare(query: $query);

        if (!$stmt) {
            throw new Exception(message: "Failed to prepare query: " . $this->dbConnection->error);
        }
        $bindParams = array_merge([$types], $params);
        $ref = new ReflectionClass(objectOrClass: 'mysqli_stmt');
        $method = $ref->getMethod(name: 'bind_param');
        $method->invokeArgs($stmt, $this->refValues($bindParams));

        $stmt->execute();

        if ($shouldReturn) {
            return $stmt;
        }
        return null;
    }

    private static function refValues(array $arr): array
    {
        $refs = [];
        foreach ($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }

        return $refs;
    }

    public function queryAndFetchAll(string $query): array
    {
        $stmt = $this->dbConnection->query(query: $query);
        return $stmt->fetch_all(mode: MYSQLI_ASSOC);
    }
}
