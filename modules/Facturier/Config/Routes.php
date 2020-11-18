<?php

$routes->setDefaultNamespace('Modules\Facturier\Controllers');
$routes->get('facturier-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('facturier-add-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('facturier-list-achat','Achat::get_all',['filter' => 'isLoggedIn']);
