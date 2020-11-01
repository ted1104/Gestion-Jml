<?php

$routes->setDefaultNamespace('Modules\Admin\Controllers');

$routes->get('login.dy','Login::index');
$routes->post('admin.dy','Login::login');
$routes->get('admin-logout.dy','Login::logout');

$routes->get('admin-home.dy','Home::index',['filter' => 'isLoggedIn']);
$routes->get('admin-property.dy','Home::property_get',['filter' => 'isLoggedIn']);
$routes->get('admin-property-detail.dy/(:num)','Home::property_get_one/$1',['filter' => 'isLoggedIn']);


$routes->get('admin-cars.dy','Home::cars_get',['filter' => 'isLoggedIn']);
$routes->get('admin-cars-detail.dy/(:num)','Home::cars_get_one/$1',['filter' => 'isLoggedIn']);

$routes->get('admin-tenders.dy','Home::tenders_get',['filter' => 'isLoggedIn']);
$routes->get('admin-tenders-detail.dy/(:num)','Home::tenders_get_one/$1',['filter' => 'isLoggedIn']);

$routes->get('admin-jobs.dy','Home::jobs_get',['filter' => 'isLoggedIn']);
$routes->get('admin-jobs-detail.dy/(:num)','Home::jobs_get_one/$1',['filter' => 'isLoggedIn']);


$routes->get('admin-auctions.dy','Home::auctions_get',['filter' => 'isLoggedIn']);
$routes->get('admin-auctions-detail.dy/(:num)','Home::auctions_get_one/$1',['filter' => 'isLoggedIn']);
