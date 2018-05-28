<?php

namespace Framework\Provider;

use Framework\Foundation\Application;
use Framework\Provider\Interfaces\Provider;
use Framework\Filesystem\File;

class FileProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $app->bind('file', new File);
    }
}