<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Comments');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Hotel::index');
$routes->get('Account/Login', 'Account::login');
$routes->get('Account/Register', 'Account::register');
$routes->get('Account/Logout', 'Account::logout');
$routes->post('Account/SubmitLogin', 'Account::submitLogin');
$routes->post('Account/SubmitRegister', 'Account::submitRegister');
$routes->get('Admin/', 'Admin::index');
$routes->get('Hotel/', 'Hotel::index');
$routes->post('Admin/GetCities', 'Admin::getCities');
$routes->post('Admin/AddCountry', 'Admin::addCountry');
$routes->post('Admin/DeleteCountry', 'Admin::deleteCountry');
$routes->post('Admin/AddCity', 'Admin::addCity');
$routes->post('Admin/DeleteCity', 'Admin::deleteCity');
$routes->post('Admin/AddHotel', 'Admin::addHotel');
$routes->post('Admin/DeleteHotel', 'Admin::deleteHotel');
$routes->post('Admin/AddUser', 'Admin::addUser');
$routes->post('Admin/AddImage', 'Admin::addImage');
$routes->post('Admin/DeleteImage', 'Admin::deleteImage');

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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
