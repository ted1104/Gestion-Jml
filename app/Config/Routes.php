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
$routes->get('/', 'Login::index');
$routes->post('login','Login::login');
$routes->get('logout','Login::logout');

$routes->get('print-code/(:any)/code','PdfGenerate::index/$1',['filter' => 'isFacturier']);
$routes->get('print-facture/(:any)/code','PdfGenerate::facture/$1');


$routes->get('config-pass-profile','Configuration::index',['filter' => 'isLoggedIn']);
$routes->get('rapport-journal-de-sorti-par-depot/(:num)/(:any)/','PdfGenerate::rapport_journal_de_sorti_par_depot/$1/$2',['filter' => 'isManager']);
$routes->get('rapport-financier-journalier/(:any)','PdfGenerate::rapport_finacier_journalier/$1',['filter' => 'isManager']);
$routes->get('rapport-stock-general/(:any)','PdfGenerate::rapport_stock_general/$1',['filter' => 'isManager']);
$routes->get('rapport-stock-entree-sortie/(:num)/(:any)/(:any)','PdfGenerate::rapport_stock_entree_sortie_interval/$1/$2/$3',['filter' => 'isManager']);
$routes->get('rapport-stock-approvisionnement/(:num)/(:any)/(:any)','PdfGenerate::rapport_approvisionnemnt_interval/$1/$2/$3',['filter' => 'isManager']);


$routes->get('cron-user-desable-account','Configuration::user_desable_account');
$routes->get('cron-user-enable-account','Configuration::user_enable_account');
$routes->get('cron-cloture-stock','Configuration::clotureStock');
$routes->get('cron-cloture-caisse','Configuration::clotureCaisse');











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
