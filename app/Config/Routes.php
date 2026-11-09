<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public / Frontend Routes
$routes->get('/', 'Home::index');
$routes->get('search', 'Home::search');
$routes->get('anggota/(:segment)', 'Home::anggotaDetail/$1');
$routes->get('karya/(:num)', 'Home::karyaDetail/$1');
$routes->get('api/search', 'Home::apiSearch');

// Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login/process', 'Auth::processLogin');
$routes->get('logout', 'Auth::logout');

// Protected Routes (Requires Login)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    // Dashboard & Profile
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('ubah-password', 'Auth::changePassword');
    $routes->post('ubah-password/update', 'Auth::updatePassword');

    // CRUD Data Anggota
    $routes->group('admin/anggota', static function ($routes) {
        $routes->get('/', 'Anggota::index');
        $routes->get('create', 'Anggota::create');
        $routes->post('store', 'Anggota::store');
        $routes->get('edit/(:segment)', 'Anggota::edit/$1');
        $routes->post('update/(:segment)', 'Anggota::update/$1');
        $routes->get('delete/(:segment)', 'Anggota::delete/$1');
        $routes->get('detail/(:segment)', 'Anggota::detail/$1');
    });

    // CRUD Data Karya
    $routes->group('admin/karya', static function ($routes) {
        $routes->get('/', 'Karya::index');
        $routes->get('create', 'Karya::create');
        $routes->post('store', 'Karya::store');
        $routes->get('edit/(:num)', 'Karya::edit/$1');
        $routes->post('update/(:num)', 'Karya::update/$1');
        $routes->get('delete/(:num)', 'Karya::delete/$1');
        $routes->get('detail/(:num)', 'Karya::detail/$1');
    });

    // CRUD Kategori
    $routes->group('admin/kategori', static function ($routes) {
        $routes->get('/', 'Kategori::index');
        $routes->post('store', 'Kategori::store');
        $routes->post('update/(:num)', 'Kategori::update/$1');
        $routes->get('delete/(:num)', 'Kategori::delete/$1');
    });

    // CRUD Users (Admin only)
    $routes->group('admin/users', ['filter' => 'auth:Admin'], static function ($routes) {
        $routes->get('/', 'User::index');
        $routes->post('store', 'User::store');
        $routes->post('update/(:num)', 'User::update/$1');
        $routes->get('delete/(:num)', 'User::delete/$1');
    });
});
