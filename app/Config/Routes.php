<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */ 
$routes->get('/', 'Pages::index');
$routes->get('/about', 'Pages::about');
$routes->get('/contact', 'Pages::contact');
$routes->get('/komik', 'Komik::index');
$routes->get('/komik/(:any)', 'Komik::detail/$1');
$routes->add('/komik/save', 'Komik::save');