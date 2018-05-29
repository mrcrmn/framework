<?php

$router->get('products/{product}', 'ProductController::index')->name('product');
