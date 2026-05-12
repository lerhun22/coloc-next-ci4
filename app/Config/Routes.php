<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'HomeController::index');

$routes->get('/test-db', 'TestDb::index');
$routes->get('/bootstrap', 'Bootstrap::index');
$routes->get('/bootstrap/check', 'Bootstrap::checkBase');

$routes->get(
    '/competition/load/(:num)',
    'CompetitionRuntimeController::load/$1'
);

$routes->get(
    'runtime/test',
    'CompetitionRuntimeController::test'
);

$routes->get(
    'slideshow',
    'SlideshowController::index'
);

$routes->get(
    'slideshow/(:num)',
    'SlideshowController::show/$1'
);

$routes->get(
    'runtime/image/(:segment)/(:segment)',
    'RuntimeImageController::show/$1/$2'
);
