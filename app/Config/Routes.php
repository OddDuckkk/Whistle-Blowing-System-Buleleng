<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::index');
$routes->get('/dashboard', 'MainController::viewDashboard');

/* ======= Pengaduan Routes ======= */
// $routes->get('/pengaduan', 'PengaduanController::getAll');
$routes->get('/pengaduan/create', 'PengaduanController::viewCreate');
$routes->post('pengaduan/store', 'PengaduanController::store');
$routes->get('/pengaduan/details/(:segment)', 'PengaduanController::viewDetails/$1');
$routes->get('/pengaduan/edit/(:segment)', 'PengaduanController::viewEdit/$1');
$routes->post('/pengaduan/update/(:segment)', 'PengaduanController::update/$1');
$routes->get('/pengaduan/delete/(:segment)', 'PengaduanController::delete/$1');
$routes->post('/pengaduan/upload-file', 'PengaduanController::uploadFile');
$routes->post('/pengaduan/delete-file', 'PengaduanController::deleteFile');
$routes->post('/pengaduan/change-status', 'PengaduanController::changeStatus');

/* ======= Pelapor Routes ======= */
$routes->get('/pengaduan/user/(:segment)', 'PengaduanController::getPelaporActivePengaduan/$1', ['filter' => 'owner']);
$routes->get('/pengaduan/user/riwayat/(:segment)', 'PengaduanController::getPelaporInactivePengaduan/$1', ['filter' => 'owner']);

/* ======= Operator Routes ======= */
$routes->get('/pengaduan/operator', 'PengaduanController::getOperatorActivePengaduan', ['filter' => 'level:operator']);
$routes->get('/pengaduan/operator/riwayat', 'PengaduanController::getOperatorInactivePengaduan', ['filter' => 'level:operator']);

/* ======= Verifikator Routes ======= */
$routes->get('/pengaduan/verifikator', 'PengaduanController::getVerifikatorActivePengaduan', ['filter' => 'level:verifikator']);
$routes->get('/pengaduan/verifikator/riwayat', 'PengaduanController::getVerifikatorInactivePengaduan', ['filter' => 'level:verifikator']);

/* ======= Peninjau Routes ======= */
$routes->get('/pengaduan/peninjau/riwayat', 'PengaduanController::getPeninjauInactivePengaduan', ['filter' => 'level:peninjau']);
$routes->get('/pengaduan/peninjau/statistik', 'PengaduanController::viewStatistics', ['filter' => 'level:peninjau']);

/* ======= Bookmark Routes ======= */
$routes->get('/bookmark/user/(:segment)', 'BookmarkController::viewBookmarks/$1', ['filter' => 'owner']);
$routes->post('/bookmark/add', 'BookmarkController::addBookmark');
$routes->post('/bookmark/remove', 'BookmarkController::removeBookmark');

/* ======= Auth Routes ======= */
$routes->get('/login/index', 'AuthController::index');
$routes->post('/login/auth', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/auth/search-nip', 'AuthController::searchNip');

/* ======= User Level Routes ======= */
$routes->get('/user-level', 'LevelController::getAllUserLevels', ['filter' => 'level:superadmin']);
$routes->get('/user-level/assign', 'LevelController::viewAssign');
$routes->post('/user-level/store', 'LevelController::store');
$routes->get('/user-level/edit/(:segment)', 'LevelController::viewEdit/$1', ['filter' => 'level:superadmin']);
$routes->post('/user-level/update/(:segment)', 'LevelController::update/$1', ['filter' => 'level:superadmin']);
$routes->get('/user-level/delete/(:segment)', 'LevelController::delete/$1', ['filter' => 'level:superadmin']);

/* ======= Error Page Routes ======= */
$routes->get('/forbidden', 'ErrorController::viewForbidden');
$routes->get('/not-found', 'ErrorController::viewNotFound');
// Override halaman 404 bawaan codeIgniter
$routes->set404Override('\App\Controllers\ErrorController::viewNotFound');

