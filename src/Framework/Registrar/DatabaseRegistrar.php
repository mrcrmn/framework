<?php

namespace Framework\Registrar;

use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;
use Framework\Database\Database;

class DatabaseRegistrar implements Registrar
{
    public function register(Application $app)
    {
        if ($app->useDb()) {
            $database = new Database;
            $config = config('database');
            $database->connect(
                $config['host'],
                $config['username'],
                $config['password'],
                $config['port'],
                $config['database']
            );
            $app->bind('db', $database);
        }
    }

    public function booted()
    {

    }
}