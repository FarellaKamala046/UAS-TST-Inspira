<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. HALAMAN UTAMA
$routes->get('/', 'Home::index');

// 2. DATABASE SETUP
$routes->group('database', function($routes) {
    $routes->get('init', 'Setup::index'); 
    $routes->get('seed', 'Setup::seed');  
});

// 3. API ENDPOINTS
$routes->group('api', function($routes) {
    
    // --- AUTHENTICATION ---
    $routes->post('register', 'AuthController::register');
    $routes->post('login', 'AuthController::login');
    $routes->get('logout', 'AuthController::logout'); // TAMBAHAN: Agar user bisa keluar dengan aman

    // --- LOOKS (OOTD) - Public ---
    $routes->get('looks', 'ApiController::getAllLooks');
    $routes->get('looks/search', 'ApiController::searchLooks'); 
    $routes->get('looks/(:num)', 'ApiController::getLookDetail/$1'); 

    // --- USERS (Profiles) - Public ---
    $routes->get('users/(:any)', 'ApiController::getUserProfile/$1');

    // --- BOARDS (Interaction) - Protected (Wajib Login) ---
    // Sekarang hanya ada SATU rute dan sudah ditempel filter 'auth'
    $routes->post('boards/(:num)/looks', 'BoardController::addLook/$1', ['filter' => 'auth']);

    // --- PROFILE INTERACTION ---
    // TAMBAHAN: Untuk menampilkan daftar foto yang sudah di-save user di profile.html
    $routes->get('my-saved/(:num)', 'BoardController::getSaved/$1'); 
});