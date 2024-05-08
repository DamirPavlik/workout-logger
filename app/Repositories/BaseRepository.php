<?php

namespace app\Repositories;

use database\Database;

class BaseRepository
{
    protected $dbConnection;

    public function __construct()
    {
        $db = new Database();
        $this->dbConnection = $db->getConnection();
    }
}
