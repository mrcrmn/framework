<?php

namespace Framework\Provider;

use Framework\Router\RouteCollection;
use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;

class RouteProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $router = new RouteCollection;
        
        $router->group(function ($router) {
            require_once base_path('routes/web.php');
        });

        $app->bind('router', $router);
    }
}