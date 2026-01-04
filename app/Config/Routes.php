<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN UTAMA
$routes->get('/', 'Home::index');

// 2. DATABASE SETUP (Akses ini sekali saja di awal)
$routes->group('database', function($routes) {
    $routes->get('init', 'Setup::index'); // URL: /database/init
    $routes->get('seed', 'Setup::seed');  // URL: /database/seed
});

// 3. FITUR BOARDS (Koleksi)
$routes->get('boards', 'BoardController::index');
$routes->post('boards', 'BoardController::create');
$routes->get('boards/search', 'BoardController::searchBoards');
$routes->get('boards/(:num)', 'BoardController::show/$1');

// 4. FITUR LOOKS (OOTD)
$routes->get('looks/search', 'BoardController::searchLooks');

// 5. API ENDPOINTS (Berikan daftar ini ke temanmu)
$routes->group('api', function($routes) {
    // Ambil semua looks
    $routes->get('looks', 'ApiController::getAllLooks');        
    // Ambil detail satu look berdasarkan ID
    $routes->get('looks/(:num)', 'ApiController::getLookDetail/$1'); 
    
    // Simpan look ke board tertentu
    $routes->post('boards/(:num)/looks', 'BoardController::addLook/$1');
});