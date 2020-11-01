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
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('whoweare','About::index');
$routes->get('whatWeDo','About::whatWeDo');


// PROPERTIES
$routes->get('property','Properties::index');
$routes->get('property-detail/(:num)','Properties::detail/$1');

// CARS
$routes->get('cars','Cars::index');
$routes->get('cars-detail/(:num)','Cars::detail/$id');

// ACTIONS
$routes->get('auctions','Auctions::index');
$routes->get('auctions-detail/(:num)','Auctions::detail/$1');

//Tenders
$routes->get('tenders','Tenders::index');
$routes->get('tenders-detail/(:num)','Tenders::detail/$1');

//Jobs
$routes->get('jobs','Jobs::index');
$routes->get('jobs-detail/(:num)','Jobs::detail/$1');

$routes->get('cart','Properties::cart');

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

/*
*
*	INCLUDE ROUTES FOR MODULES
*
*/
if(file_exists(ROOTPATH.'modules')){
	$modulesPath = ROOTPATH.'modules/';
	$modules = scandir($modulesPath);

	foreach ($modules as $module) {
		if($module === '.' || $module ==='..') continue;
		if(is_dir($modulesPath).'/'.$module){
			$routesPath = $modulesPath . $module . '/Config/Routes.php';
			if(file_exists($routesPath)){
				require ($routesPath);
			}else{
				continue;
			}
		}
	}
}
