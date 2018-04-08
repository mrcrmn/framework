<?php

$app = new Framework\Foundation\Application;

require_once base_path('src/Framework/Support/helpers.php');

$app->bind(
    'config', new Framework\Foundation\Config(base_path('config/'))
);

foreach (config('services') as $service => $instance)
{
    $app->bind(
        $service, new $instance
    );
}

return $app;
