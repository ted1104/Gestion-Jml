<?php

$routes->setDefaultNamespace('Modules\Facturier\Controllers');
$routes->get('facturier-dashboard','Dashboard::index',['filter' => 'isFacturier']);
$routes->get('facturier-add-achat','Achat::index',['filter' => 'isFacturier']);
$routes->get('facturier-list-achat','Achat::get_all',['filter' => 'isFacturier']);
$routes->get('facturier-config-system','Dashboard::getConfigSystem',['filter' => 'isFacturier']);
$routes->get('facturier-stock-pv','Dashboard::getStockPv',['filter' => 'isFacturier']);
