<?php

namespace Framework\Registrar\Interfaces;

use Framework\Foundation\Application;

interface Registrar
{
    /**
     * Registers a service and binds it to the Application.
     *
     * @param Application $app
     * @return void
     */
    public function register(Application $app);
    
    /**
     * Runs once when all services have been registered.
     *
     * @return void
     */
    public function booted();
}