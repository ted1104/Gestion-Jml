<?php

$routes->setDefaultNamespace('Modules\Gerant\Controllers');
$routes->get('gerant-dashboard','Dashboard::index',['filter' => 'isGerant']);
$routes->get('gerant-list-achat','Dashboard::getAchatList',['filter' => 'isGerant']);
$routes->get('gerant-list-achat-partiel','Dashboard::getAchatListPartiel',['filter' => 'isGerant']);
$routes->get('gerant-stock','Dashboard::getStock',['filter' => 'isGerant']);
$routes->get('gerant-stock-pv','Dashboard::getStockPv',['filter' => 'isGerant']);
$routes->get('gerant-histo-appro','Dashboard::getHistoriqueAppro',['filter' => 'isGerant']);
$routes->get('gerant-histo-appro-inter-depot','Dashboard::getHistoriqueApproInterDepot',['filter' => 'isGerant']);
$routes->get('gerant-config-system','Dashboard::getConfigSystem',['filter' => 'isGerant']);
$routes->get('gerant-add-pv-historique','Dashboard::addPvPerdue',['filter' => 'isGerant']);
$routes->get('gerant-historique-pv','Dashboard::getPvPerdue',['filter' => 'isGerant']);
$routes->get('gerant-stock-personnel','Dashboard::getStockPersonnel',['filter' => 'isGerant']);
$routes->get('gerant-histo-transfert','Dashboard::getHistoTransfert',['filter' => 'isGerant']);
$routes->get('gerant-rapport','Dashboard::getRapport',['filter' => 'isGerant']);
