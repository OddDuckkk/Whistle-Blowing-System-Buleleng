<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/dashboard', 'MainController::viewDashboard');

/* ======= Pengaduan Routes ======= */
$routes->get('/pengaduan', 'PengaduanController::getAll');
$routes->get('/pengaduan/create', 'PengaduanController::viewCreate');
$routes->post('pengaduan/store', 'PengaduanController::store');
$routes->get('/pengaduan/details/(:segment)', 'PengaduanController::viewDetails/$1');
$routes->get('/pengaduan/edit/(:segment)', 'PengaduanController::viewEdit/$1');
$routes->post('/pengaduan/update/(:segment)', 'PengaduanController::update/$1');
$routes->get('/pengaduan/delete/(:segment)', 'PengaduanController::delete/$1');
$routes->post('/pengaduan/upload-file', 'PengaduanController::uploadFile');
$routes->post('/pengaduan/delete-file', 'PengaduanController::deleteFile');
$routes->post('/pengaduan/change-status', 'PengaduanController::changeStatus');

$routes->get('/pengaduan/user/(:segment)', 'PengaduanController::getPelaporActivePengaduan/$1');
$routes->get('/pengaduan/user/riwayat/(:segment)', 'PengaduanController::getPelaporInactivePengaduan/$1');

$routes->get('/pengaduan/operator', 'PengaduanController::getOperatorActivePengaduan');
$routes->get('/pengaduan/operator/riwayat', 'PengaduanController::getOperatorInactivePengaduan');

$routes->get('/pengaduan/verifikator', 'PengaduanController::getVerifikatorActivePengaduan');
$routes->get('/pengaduan/verifikator/riwayat', 'PengaduanController::getVerifikatorInactivePengaduan');



$routes->get('/login/index', 'AuthController::index');
$routes->post('/login/auth', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/auth/search-nip', 'AuthController::searchNip');

$routes->get('/user-level', 'LevelController::getAllUserLevels');
$routes->get('/user-level/assign', 'LevelController::viewAssign');
$routes->post('/user-level/store', 'LevelController::store');
$routes->get('/user-level/edit/(:segment)', 'LevelController::viewEdit/$1');
$routes->post('/user-level/update/(:segment)', 'LevelController::update/$1');
$routes->get('/user-level/delete/(:segment)', 'LevelController::delete/$1');

