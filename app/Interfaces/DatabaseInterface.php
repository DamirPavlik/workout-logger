<?php

namespace app\Interfaces;

interface DatabaseInterface
{
    public function __construct();
    public function getConnection();
}