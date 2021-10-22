<?php

namespace App\infra;

use Databases\DB;

class BaseDBRepository
{
    protected $connection;

    public function __construct()
    {
        $this->connection = DB::getInstance();

    }
}
