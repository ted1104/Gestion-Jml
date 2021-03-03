<?php

$routes->setDefaultNamespace('Modules\Admin\Controllers');
$routes->get('admin-dashboard','Dashboard::index',['filter' => 'isManager']);
$routes->get('admin-add-article','Articles::index',['filter' => 'isManager']);
$routes->get('admin-add-appro','Approv::index',['filter' => 'isManager']);
$routes->get('admin-list-achat','Achat::index',['filter' => 'isManager']);
$routes->get('admin-list-negotiation-achat','Achat::negotiation_list',['filter' => 'isManager']);
$routes->get('admin-list-article','Articles::list',['filter' => 'isManager']);
$routes->get('admin-histo-appro','Approv::historique',['filter' => 'isManager']);
$routes->get('admin-stock','Approv::stockDepots',['filter' => 'isManager']);
$routes->get('admin-config-depot','Dashboard::config_depot',['filter' => 'isManager']);
$routes->get('admin-config-etat-critique','Dashboard::config_critique',['filter' => 'isManager']);
$routes->get('admin-caisse','Dashboard::getCaissierMontant',['filter' => 'isManager']);
$routes->get('admin-encaissement-interne','Dashboard::getEncaissementInterne',['filter' => 'isManager']);
$routes->get('admin-decaissement-externe','Dashboard::getDecaissementInterne',['filter' => 'isManager']);
$routes->get('admin-add-users','Dashboard::createUsers',['filter' => 'isManager']);
$routes->get('admin-list-users','Dashboard::getAllUsers',['filter' => 'isManager']);
$routes->get('admin-histo-appro-inter-depot','Approv::historiqueInterDepot',['filter' => 'isManager']);
$routes->get('admin-encaissement-externe','Dashboard::getEncaissementExterne',['filter' => 'isManager']);
$routes->get('admin-stock-pv','Dashboard::getStockPv',['filter' => 'isManager']);
$routes->get('admin-rapport','Dashboard::getRapport',['filter' => 'isManager']);
$routes->get('admin-list-achat-partiel','Achat::getAchatPartiel',['filter' => 'isManager']);
$routes->get('admin-config-system','Dashboard::getConfigSystem',['filter' => 'isManager']);
$routes->get('admin-histo-transfert','Approv::getHistoTransfert',['filter' => 'isManager']);




































// admin-histo-appro
