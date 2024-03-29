<?php namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
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

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->add('get-data', 'Test::get_data');
$routes->add('create', 'Test::create');
$routes->add('get-data-query-builer', 'Test::get_data_query_builer');
$routes->add('join-table', 'Test::join_table');
$routes->get('edit-data/(:any)', 'Test::edit/$1');
$routes->group('admin', function($routes) { //http://localhost/ci/admin/faq
	$routes->get('faq', function() {
		echo "It's static data directly form routes no any views or controller are used for it.";
	});
});
$routes->get('learn-insert', 'Learn::index');
$routes->get('learn-get', 'Learn::get');
$routes->get('learn-update', 'Learn::update');
$routes->get('learn-delete', 'Learn::delete');
$routes->get('get-flash-data', 'Learn::get_flash_data');

/**
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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
