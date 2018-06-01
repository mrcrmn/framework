<?php

namespace Framework\Registrar;

use Framework\View\Factory;
use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;

class ViewRegistrar implements Registrar
{
    public function register(Application $app)
    {
        $app->bind('view', 
            new Factory(base_path('resources/views/'))
        );
    }

    public function booted()
    {

    }
}