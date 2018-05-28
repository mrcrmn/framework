<?php

namespace Framework\Provider;

use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;
use Framework\Database\Database;

class DatabaseProvider implements Provider
{
    public function boot()
    {

    }

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
}