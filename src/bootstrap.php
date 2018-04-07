<?php

$app = new Framework\Foundation\Application;

function dd($var)
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

function app($service = null)
{
    global $app;

    if (isset($service)) {
        return $app->get($service);
    }

    return $app;
}

function db()
{
    return app('db');
}

function config($handle)
{
    return app('config')->get($handle);
}

$app->bind(
    'config', new \Framework\Foundation\Config(base_path('config/'))
);

foreach (config('services') as $service => $instance)
{
    $app->bind(
        $service, new $instance
    );
}

return $app;
