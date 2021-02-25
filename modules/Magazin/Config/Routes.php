<?php

$routes->setDefaultNamespace('Modules\Magazin\Controllers');
$routes->get('magaz-dashboard','Dashboard::index',['filter' => 'isMagazinier']);
$routes->get('magaz-list-achat','Achat::index',['filter' => 'isMagazinier']);
$routes->get('magaz-list-achat-faveur','Achat::getAchatFaveur',['filter' => 'isMagazinier']);
$routes->get('magaz-histo-appro','Achat::getHistoriqueAppro',['filter' => 'isMagazinier']);
$routes->get('magaz-stock','Achat::getStockDepot',['filter' => 'isMagazinier']);
$routes->get('magaz-add-appro','Achat::addAppro',['filter' => 'isMagazinier']);
$routes->get('magaz-add-appro-to-depot','Achat::addApproInterDepot',['filter' => 'isMagazinier']);
$routes->get('magaz-histo-appro-inter-depot','Achat::getHistoriqueApproInterDepot',['filter' => 'isMagazinier']);
$routes->get('magaz-pv','Achat::getStockPv',['filter' => 'isMagazinier']);
$routes->get('magaz-list-achat-partiel','Achat::getAchatPartiel',['filter' => 'isMagazinier']);
$routes->get('magaz-config-system','Dashboard::getConfigSystem',['filter' => 'isMagazinier']);
