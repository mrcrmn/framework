<?php

namespace Framework\Provider;

use Framework\Session\Session;
use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;

class SessionProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $app->bind('session', new Session);
    }
}