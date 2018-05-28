<?php

namespace Framework\Provider;

use Framework\View\Factory;
use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;

class ViewProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $app->bind('view', 
            new Factory(base_path('resources/views/'))
        );
    }
}