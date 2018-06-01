<?php

namespace Framework\Registrar;

use Framework\Router\RouteCollection;
use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;

class RouteRegistrar implements Registrar
{
    protected $router;

    public function register(Application $app)
    {
        $this->router = $app->bind('router', new RouteCollection);
    }

    public function booted()
    {
        $this->router->group(function ($router) {
            require_once base_path('routes/web.php');
        });
    }
}