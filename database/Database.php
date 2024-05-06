<?php

namespace database;

use Dotenv\Dotenv;

require __DIR__.'/../vendor/autoload.php';

class Database
{
    private $connection;

    public function __construct()
    {
        $this->loadEnv();
        $this->connect();
    }

    private function loadEnv(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    private function connect(): void
    {
        $hostname = $_ENV["DB_HOSTNAME"];
        $username = $_ENV["DB_USERNAME"];
        $password = $_ENV["DB_PASSWORD"];
        $name = $_ENV["DB_NAME"];

        $this->connection = mysqli_connect(
            hostname: $hostname,
            username: $username,
            password: $password,
            database: $name
        );

        if ($this->connection->connect_error) {
            die("Connection to the database failed");
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }
}