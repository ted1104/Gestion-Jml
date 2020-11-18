<?php

$routes->setDefaultNamespace('Modules\Caisse\Controllers');
$routes->get('caissier-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('caissier-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('caissier-add-achat','Achat::achatCaissier',['filter' => 'isLoggedIn']);
$routes->get('caissier-add-decaissement','Achat::decaissementSend',['filter' => 'isLoggedIn']);
$routes->get('caissier-list-decaissement','Achat::decaissementListCaissierMain',['filter' => 'isLoggedIn']);
