<?php

$router->get('products/{product}', 'HomeController::index')->name('product');
$router->get('products/{product}/{comments}', 'HomeController::test')->name('product.comments');