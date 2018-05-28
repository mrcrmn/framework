<?php

namespace Framework\Provider;

use Framework\Router\RouteCollection;
use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;

class RouteProvider implements Provider
{
    protected $router;

    public function boot()
    {
        $this->router->group(function ($router) {
            require_once base_path('routes/web.php');
        });
    }

    public function register(Application $app)
    {
        $this->router = $app->bind('router', new RouteCollection);
    }
}