<?php

namespace Framework\Registrar;

use Framework\Foundation\Application;
use Framework\Registrar\Interfaces\Registrar;
use Framework\Support\Asset;

class AssetRegistrar implements Registrar
{
    public function register(Application $app)
    {
        $app->bind('asset', new Asset(base_path('public/')));
    }

    public function booted()
    {

    }
}