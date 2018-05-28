<?php

/**
 * Create a new App instance.
 */
$app = new Framework\Foundation\Application;

/**
 * Require helper functions and bind the Config Service to the Application Container.
 */
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

/**
 * Register and boot all Services.
 */
$app->makeServices();

/**
 * Return the Application.
 */
return $app;
