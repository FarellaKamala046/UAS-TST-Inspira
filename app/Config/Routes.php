<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN UTAMA (Hanya untuk cek web jalan)
$routes->get('/', 'Home::index');

// 2. DATABASE SETUP (Akses via browser: /database/init & /database/seed)
$routes->group('database', function($routes) {
    $routes->get('init', 'Setup::index'); 
    $routes->get('seed', 'Setup::seed');  
});

// 3. API ENDPOINTS (Semua komunikasi data lewat sini)
$routes->group('api', function($routes) {
    
    // --- AUTHENTICATION ---
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');

    // --- LOOKS (OOTD) - Public ---
    $routes->get('looks', 'ApiController::getAllLooks');
    $routes->get('looks/search', 'ApiController::searchLooks'); // Harus di atas (:num) agar tidak dianggap ID
    $routes->get('looks/(:num)', 'ApiController::getLookDetail/$1'); 

    // --- USERS (Profiles) - Public ---
    $routes->get('users/(:any)', 'ApiController::getUserProfile/$1');

    // --- BOARDS (Interaction) - Protected (Wajib Login) ---
    // Sementara kita biarkan begini, nanti kita pasang filter 'auth' di sini
    $routes->post('boards/(:num)/looks', 'BoardController::addLook/$1');
    $routes->post('boards/(:num)/looks', 'BoardController::addLook/$1', ['filter' => 'auth']);
});