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
$routes->get('admin-config-list-article','Dashboard::config_articles',['filter' => 'isManager']);


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
$routes->get('admin-stock-personnel','Approv::getStockPersonnel',['filter' => 'isManager']);

$routes->get('admin-add-vente','Achat::achatAddAdmin',['filter' => 'isManager']);
$routes->get('admin-list-ventes','Achat::achatListAdmin',['filter' => 'isManager']);

$routes->get('admin-add-client','Dashboard::addClient',['filter' => 'isManager']);
$routes->get('admin-list-client','Dashboard::getListClient',['filter' => 'isManager']);

$routes->get('admin-add-pv-historique','Achat::addPvPerdue',['filter' => 'isManager']);
$routes->get('admin-historique-pv','Achat::getPvPerdue',['filter' => 'isManager']);
$routes->get('admin-list-achat-a-retirer','Achat::getAchatAretirer',['filter' => 'isManager']);

$routes->get('admin-config-zone','Dashboard::getConfigZone',['filter' => 'isManager']);












































// admin-histo-appro
