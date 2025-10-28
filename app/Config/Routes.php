<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->setDefaultNamespace('App\Controllers');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->resource('tasks');
});