<?php

/**
 * Create a new App instance.
 */
$app = new Framework\Foundation\Application;

require_once base_path('src/Framework/Support/helpers.php');

$app->bind(
    'config', new Framework\Foundation\Config(base_path('config/'))
);

/**
 * We need to set the status.
 */
$app->setStatus();
if ($app->getStatus() === 1) {
    $app->setErrorReporting();
}

foreach (config('services') as $service => $instance)
{
    $app->bind(
        $service, new $instance
    );
}

return $app;
