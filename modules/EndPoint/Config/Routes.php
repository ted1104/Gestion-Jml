<?php

$routes->setDefaultNamespace('Modules\EndPoint\Controllers');
$routes->group('api/v1', function($routes){
  $routes->get('users-get-all','Users::index');
  $routes->post('users-post-one','Users::create_user');

  /*
  * ENDPOINTS PROPERTIES
  */
  $routes->get('properties-get-all','Properties::index');
  $routes->post('properties-post-one','Properties::properties_create');
  $routes->get('properties-get-one/(:num)/property','Properties::propertie_get_one/$1');

  /*
  * ENDPOINTS CARS
  */
  $routes->get('cars-get-all','Cars::index');
  $routes->post('cars-post-one','Cars::cars_create');
  $routes->get('cars-get-one/(:num)/cars','Cars::cars_get_one/$1');


  /*
  * ENDPOINTS TENDERS
  */
  $routes->get('tenders-get-all','Tenders::index');
  $routes->post('tenders-post-one','Tenders::tenders_create');
  $routes->get('tenders-get-one/(:num)/tenders','Tenders::tenders_get_one/$1');

  /*
  * ENDPOINTS JOBS
  */
  $routes->get('jobs-get-all','Jobs::index');
  $routes->post('jobs-post-one','Jobs::jobs_create');
  $routes->get('jobs-get-one/(:num)/jobs','Jobs::jobs_get_one/$1');

  /*
  * ENDPOINTS AUCTIONS
  */
  $routes->get('auctions-get-all','Auctions::index');
  $routes->post('auctions-post-one','Auctions::auctions_create');
  $routes->get('auctions-get-one/(:num)/auctions','Auctions::auctions_get_one/$1');


  /*
  * LES ROUTES DES TABLES STATIQUE
  *
  */
  $routes->get('province-get-all','Statique::province_get');
  $routes->post('province-post-one','Statique::province_create');

  $routes->get('districts-get-all','Statique::district_get');
  $routes->post('districts-post-one','Statique::district_create');
  $routes->get('districts-get-all/(:num)/province','Statique::district_get_by_province/$1');

  $routes->get('sectors-get-all','Statique::sectors_get');
  $routes->post('sectors-post-one','Statique::sectors_create');
  $routes->get('sectors-get-all/(:num)/district','Statique::sectors_get_by_district/$1');

  $routes->get('cells-get-all','Statique::cells_get');
  $routes->post('cells-post-one','Statique::cells_create');
  $routes->get('cells-get-all/(:num)/sectors','Statique::cells_get_by_sectors/$1');

  $routes->get('villages-get-all','Statique::village_get');
  $routes->post('villages-post-one','Statique::village_create');
  $routes->get('villages-get-all/(:num)/cells','Statique::village_get_by_cells/$1');









});
