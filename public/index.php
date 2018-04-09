<?php

/**
 * The base path functions which makes it easy to include files.
 *
 * @param string $path
 * @return string
 */
function base_path($path = '')
{
    return __DIR__ .'/../' . ltrim($path, '/');
}

/**
 * We need to require the autloader and boostrap the application.
 */
require_once base_path('src/autoloader.php');
$app = require_once base_path('src/bootstrap.php');

/**
 * Next we create a Request Instance from globals like $_POST, $_GET etc.
 */
$request = $app->bind(
    'request', new Framework\Http\Request
);


/**
 * The Kernel turns the Request into a Response.
 */
$kernel = new Framework\Http\Kernel($app);
$response = $kernel->handle($request);

/**
 * We send the Response to the client.
 */
$response->send();

/**
 * Finally we terminate the Request.
 */
$kernel->terminate($request, $response);
