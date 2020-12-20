<?php

$routes->setDefaultNamespace('Modules\Magazin\Controllers');
$routes->get('magaz-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('magaz-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('magaz-histo-appro','Achat::getHistoriqueAppro',['filter' => 'isLoggedIn']);
$routes->get('magaz-stock','Achat::getStockDepot',['filter' => 'isLoggedIn']);
$routes->get('magaz-add-appro','Achat::addAppro',['filter' => 'isLoggedIn']);
