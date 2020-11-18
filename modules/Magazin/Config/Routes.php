<?php

$routes->setDefaultNamespace('Modules\Magazin\Controllers');
$routes->get('magaz-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('magaz-list-achat','Achat::index',['filter' => 'isLoggedIn']);
