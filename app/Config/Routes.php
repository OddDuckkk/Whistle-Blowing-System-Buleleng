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
$routes->get('/pengaduan/details/(:segment)', 'PengaduanController::viewDetails/$1');
$routes->get('/pengaduan/edit/(:segment)', 'PengaduanController::viewEdit/$1');
$routes->post('/pengaduan/update/(:segment)', 'PengaduanController::update/$1');
$routes->get('/pengaduan/delete/(:segment)', 'PengaduanController::delete/$1');
$routes->get('/pengaduan/user/(:segment)', 'PengaduanController::getByUserId/$1');

$routes->get('/login/index', 'AuthController::index');
$routes->post('/login/auth', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/validate-nip', 'AuthController::validateNip');
$routes->post('/auth/search-nip', 'AuthController::searchNip');


$routes->get('/userlevel', 'LevelController::getAllUserLevels');
$routes->get('/userlevel/assign', 'LevelController::viewAssignUserLevel');
$routes->post('/userlevel/store', 'LevelController::store');

