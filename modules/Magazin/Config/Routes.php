<?php

$routes->setDefaultNamespace('Modules\Magazin\Controllers');
$routes->get('magaz-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('magaz-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('magaz-list-achat-faveur','Achat::getAchatFaveur',['filter' => 'isLoggedIn']);
$routes->get('magaz-histo-appro','Achat::getHistoriqueAppro',['filter' => 'isLoggedIn']);
$routes->get('magaz-stock','Achat::getStockDepot',['filter' => 'isLoggedIn']);
$routes->get('magaz-add-appro','Achat::addAppro',['filter' => 'isLoggedIn']);
$routes->get('magaz-add-appro-to-depot','Achat::addApproInterDepot',['filter' => 'isLoggedIn']);
$routes->get('magaz-histo-appro-inter-depot','Achat::getHistoriqueApproInterDepot',['filter' => 'isLoggedIn']);
$routes->get('magaz-pv','Achat::getStockPv',['filter' => 'isLoggedIn']);
$routes->get('magaz-list-achat-partiel','Achat::getAchatPartiel',['filter' => 'isLoggedIn']);
$routes->get('magaz-config-system','Dashboard::getConfigSystem',['filter' => 'isLoggedIn']);
