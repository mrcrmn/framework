<?php

namespace Framework\Provider;

use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;
use Framework\Support\Asset;

class AssetProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $app->bind('asset', new Asset(base_path('public/')));
    }
}