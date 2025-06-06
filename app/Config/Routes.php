<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::getAbout');
$routes->get('gallery', 'Gallery::index');
$routes->get('gallery/index', 'Gallery::index');
$routes->get('blog', 'Home::getBlog');

// Migration route (remove this after use)
$routes->get('run-migration', 'MigrateController::runMigration');
$routes->get('show-payments-table', 'MigrateController::showPaymentsTable');
$routes->get('run-raw-sql', 'MigrateController::runRawSQL');

// Auth routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attemptLogin');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::attemptRegister');
$routes->get('logout', 'Auth::logout');
$routes->get('forgot-password', 'Auth::getForgotPassword');
$routes->post('forgot-password', 'Auth::postForgotPassword');
$routes->get('reset-password/(:any)', 'Auth::getResetPassword/$1');
$routes->post('reset-password', 'Auth::postResetPassword');

// Car routes
$routes->get('cars', 'Cars::index');
$routes->get('cars/(:num)', 'Cars::show/$1');
$routes->get('cars/category/(:num)', 'Cars::byCategory/$1');

// Rental routes
$routes->get('rentals', 'Rentals::index', ['filter' => 'auth']);
$routes->get('rentals/create/(:num)', 'Rentals::create/$1', ['filter' => 'auth']);
$routes->post('rentals/store', 'Rentals::store', ['filter' => 'auth']);
$routes->get('rentals/(:num)', 'Rentals::show/$1', ['filter' => 'auth']);
$routes->post('rentals/upload-payment/(:num)', 'Rentals::uploadPayment/$1', ['filter' => 'auth']);
$routes->post('rentals/submit-review/(:num)', 'Rentals::submit_review/$1', ['filter' => 'auth']);

// Admin routes
$routes->group('admin', ['filter' => 'admin'], function($routes) {
    $routes->get('dashboard', 'Admin\Dashboard::index');
    
    // Admin car management
    $routes->get('cars', 'Admin\Cars::index');
    $routes->get('cars/create', 'Admin\Cars::create');
    $routes->post('cars/store', 'Admin\Cars::store');
    $routes->get('cars/edit/(:num)', 'Admin\Cars::edit/$1');
    $routes->post('cars/update/(:num)', 'Admin\Cars::update/$1');
    $routes->get('cars/delete/(:num)', 'Admin\Cars::delete/$1');
    
    // Admin order management
    $routes->get('orders', 'Admin\Orders::index');
    $routes->get('orders/(:num)', 'Admin\Orders::show/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\Orders::updateStatus/$1');
    $routes->post('orders/approve-payment/(:num)', 'Admin\Orders::approvePayment/$1');
    $routes->get('orders/export-excel', 'Admin\Orders::exportExcel');
    
    // Admin review management
    $routes->get('reviews', 'Admin\Reviews::index');
    $routes->get('reviews/details/(:num)', 'Admin\Reviews::details/$1');
    $routes->get('reviews/approve/(:num)', 'Admin\Reviews::approve/$1');
    $routes->get('reviews/reject/(:num)', 'Admin\Reviews::reject/$1');
    $routes->get('reviews/delete/(:num)', 'Admin\Reviews::delete/$1');
    
    // Admin category management
    $routes->get('categories', 'Admin\Categories::index');
    $routes->get('categories/create', 'Admin\Categories::create');
    $routes->post('categories/store', 'Admin\Categories::store');
    $routes->get('categories/edit/(:num)', 'Admin\Categories::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\Categories::update/$1');
    $routes->get('categories/delete/(:num)', 'Admin\Categories::delete/$1');
    $routes->get('categories/(:num)', 'Admin\Categories::show/$1');
    $routes->get('categories/search', 'Admin\Categories::search');
    
    // Admin user management
    $routes->get('users', 'Admin\Users::index');
    $routes->get('users/(:num)', 'Admin\Users::show/$1');
    $routes->get('users/edit/(:num)', 'Admin\Users::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\Users::update/$1');
    $routes->post('users/update-status', 'Admin\Users::updateStatus');
    $routes->get('users/search', 'Admin\Users::search');
    $routes->get('users/delete/(:num)', 'Admin\Users::delete/$1');
    
    // Admin payment management
    $routes->get('payments', 'Admin\Payments::index');
    $routes->get('payments/(:num)', 'Admin\Payments::show/$1');
    $routes->post('payments/update-status/(:num)', 'Admin\Payments::updateStatus/$1');
    $routes->get('payments/filter', 'Admin\Payments::filter');
    $routes->get('payments/export-csv', 'Admin\Payments::exportCsv');
    
    // Admin reports
    $routes->get('reports', 'Admin\Dashboard::reports');
});

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

