<?php

namespace Framework\Database;

class Database extends \PDO
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct()
    {
        $config = config('database');
        parent::__construct(
            sprintf("mysql:host=%s;dbname=%s", $config['host'], $config['database']),
            $config['username'],
            $config['password']
        );
    }
}
