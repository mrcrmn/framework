<?php

namespace Framework\Provider;

use Framework\Foundation\Application;
use Framework\Translation\Translator;
use Framework\Provider\Interfaces\Provider;

class TranslationProvider implements Provider
{
    public function boot()
    {

    }

    public function register(Application $app)
    {
        $app->bind('trans', new Translator);
    }
}