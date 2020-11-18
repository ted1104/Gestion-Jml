<?php

$routes->setDefaultNamespace('Modules\Admin\Controllers');
$routes->get('admin-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('admin-add-article','Articles::index',['filter' => 'isLoggedIn']);
$routes->get('admin-add-appro','Approv::index',['filter' => 'isLoggedIn']);
$routes->get('admin-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('admin-list-negotiation-achat','Achat::negotiation_list',['filter' => 'isLoggedIn']);






// admin-histo-appro
