<?php

namespace Framework\Registrar;

use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;
use Framework\Database\Connectors\DatabaseConnection;

class DatabaseRegistrar implements Registrar
{
    public function register(Application $app)
    {
        $config = config('database');

        $database = new DatabaseConnection(
            $config['host'],
            $config['username'],
            $config['password'],
            $config['port'],
            $config['database']
        );

        
        $app->bind('db', $database);
    }

    public function booted()
    {

    }
}