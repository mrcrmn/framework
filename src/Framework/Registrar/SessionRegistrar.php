<?php

namespace Framework\Registrar;

use Framework\Session\Session;
use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;

class SessionRegistrar implements Registrar
{
    protected $session;

    public function register(Application $app)
    {
        $this->session = $app->bind('session', new Session);
    }

    public function booted()
    {
        $this->session->generateCsrfToken();
    }
}