<?php

namespace Framework\Provider\Interfaces;

use Framework\Foundation\Application;

interface Provider
{
    public function boot();

    public function register(Application $app);
}