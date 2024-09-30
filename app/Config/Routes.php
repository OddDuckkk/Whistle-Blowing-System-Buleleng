<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/dashboard', 'MainController::viewDashboard');
$routes->get('/pengaduan', 'PengaduanController::getAll');
$routes->get('/pengaduan/create', 'PengaduanController::viewCreate');
$routes->post('pengaduan/store', 'PengaduanController::store');
$routes->get('/pengaduan/details/(:num)', 'PengaduanController::viewDetails/$1');
$routes->get('/pengaduan/edit/(:num)', 'PengaduanController::viewEdit/$1');
$routes->post('/pengaduan/update/(:num)', 'PengaduanController::update/$1');
$routes->get('/pengaduan/delete/(:num)', 'PengaduanController::delete/$1');
$routes->get('/pengaduan/user/(:num)', 'PengaduanController::getByUserId/$1');
$routes->get('/login/index', 'AuthController::index');
$routes->post('/login/auth', 'AuthController::login');
$routes->get('/auth/changerole/(:num)', 'AuthController::changeRole/$1');


