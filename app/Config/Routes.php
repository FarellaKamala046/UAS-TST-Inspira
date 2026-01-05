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
    $routes->get('logout', 'AuthController::logout');

    // --- LOOKS (OOTD) - Public ---
    $routes->get('looks', 'ApiController::getAllLooks');
    $routes->get('looks/search', 'ApiController::searchLooks'); 
    $routes->get('looks/(:num)', 'ApiController::getLookDetail/$1'); 

    // --- USERS (Profiles) - Public ---
    $routes->get('users/(:any)', 'ApiController::getUserProfile/$1');

    // --- BOARDS (Interaction) ---
    $routes->post('boards/(:num)/looks', 'BoardController::addLook/$1', ['filter' => 'auth']);

    $routes->post('quick-save', 'BoardController::quickSave'); 
    $routes->delete('pins/(:num)', 'BoardController::deletePin/$1');
    // --- PROFILE INTERACTION ---
    $routes->get('my-saved/(:num)', 'BoardController::getSaved/$1'); 
});