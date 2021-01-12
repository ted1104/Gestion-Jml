<?php

$routes->setDefaultNamespace('Modules\Admin\Controllers');
$routes->get('admin-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('admin-add-article','Articles::index',['filter' => 'isLoggedIn']);
$routes->get('admin-add-appro','Approv::index',['filter' => 'isLoggedIn']);
$routes->get('admin-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('admin-list-negotiation-achat','Achat::negotiation_list',['filter' => 'isLoggedIn']);
$routes->get('admin-list-article','Articles::list',['filter' => 'isLoggedIn']);
$routes->get('admin-histo-appro','Approv::historique',['filter' => 'isLoggedIn']);
$routes->get('admin-stock','Approv::stockDepots',['filter' => 'isLoggedIn']);
$routes->get('admin-config-depot','Dashboard::config_depot',['filter' => 'isLoggedIn']);
$routes->get('admin-config-etat-critique','Dashboard::config_critique',['filter' => 'isLoggedIn']);
$routes->get('admin-caisse','Dashboard::getCaissierMontant',['filter' => 'isLoggedIn']);
$routes->get('admin-decaissement','Dashboard::getDecaissement',['filter' => 'isLoggedIn']);
$routes->get('admin-add-users','Dashboard::createUsers',['filter' => 'isLoggedIn']);
$routes->get('admin-list-users','Dashboard::getAllUsers',['filter' => 'isLoggedIn']);
$routes->get('admin-histo-appro-inter-depot','Approv::historiqueInterDepot',['filter' => 'isLoggedIn']);
$routes->get('admin-encaissement','Dashboard::getEncaissementExterne',['filter' => 'isLoggedIn']);


























// admin-histo-appro
