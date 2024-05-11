<?php

namespace app\Repositories;

use database\Database;

class BaseRepository
{
    protected \mysqli $dbConnection;

    public function __construct()
    {
        $db = new Database();
        $this->dbConnection = $db->getConnection();
    }
}
