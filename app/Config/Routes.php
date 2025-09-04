<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ 
$routes->get('/', 'Home::index');
$routes->get('/about/(:any)/(:num)', 'About::index/$1/$2');
$routes->get("/users", "Admin\Users::index");