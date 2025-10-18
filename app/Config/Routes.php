<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Averias::index');
$routes->get('averias', 'Averias::index');
$routes->get('averias/create', 'Averias::create');
$routes->post('averias/store', 'Averias::store');
$routes->get('averias/edit/(:num)', 'Averias::edit/$1');
$routes->post('averias/update/(:num)', 'Averias::update/$1');
$routes->get('averias/delete/(:num)', 'Averias::delete/$1');
$routes->get('averias/cumplidas', 'Averias::cumplidas');
$routes->get('averias/chat/(:num)', 'Averias::chat/$1');
$routes->get('averias/mensajes/(:num)', 'Averias::mensajes/$1');

$routes->get('websocket', 'WebSocketController::index');
$routes->get('websocket/status', 'WebSocketController::status');
