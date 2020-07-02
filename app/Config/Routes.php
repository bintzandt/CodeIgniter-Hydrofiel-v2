<?php namespace Config;

use App\Models\EventModel;
use App\Models\PageModel;

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
$routes->get('/', 'Home::index', ['as' => 'home']);
$routes->get('switchLanguage', 'Home::switchLanguage', ['as' => 'switchLanguage']);

/**
 * Authentication routes
 */
$routes->group('', function($routes){
	// Login / logout
	$routes->get('login', 'Auth::login', ['as' => 'login']);
	$routes->post('login', 'Auth::attemptLogin');
	$routes->get('logout', 'Auth::logout', ['as' => 'logout']);

	// Reset password
	$routes->get('forgot', 'Auth::forgotPassword', ['as' => 'forgot']);
	$routes->post('forgot', 'Auth::attemptForgot');
	$routes->get('reset-password', 'Auth::resetPassword', ['as' => 'reset-password']);
	$routes->post('reset-password', 'Auth::attemptReset');
});

$routes->get('page/(:num)', 'Page::index/$1');
$routes->post('user/edit/(:num)', 'User::save/$1');

$routes->get('event/(:num)', 'Event::id/$1');
$routes->post('event/(:num)', 'Event::handleFormSubmission/$1');

$routes->post('admin/mail/', 'Admin\Mail::handleEmailFormSubmission');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
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
