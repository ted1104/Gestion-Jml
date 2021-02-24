<?php

$routes->setDefaultNamespace('Modules\Caisse\Controllers');
$routes->get('caissier-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('caissier-list-achat','Achat::index',['filter' => 'isLoggedIn']);
$routes->get('caissier-add-achat','Achat::achatCaissier',['filter' => 'isLoggedIn']);
$routes->get('caissier-add-decaissement','Achat::decaissementSend',['filter' => 'isLoggedIn']);
$routes->get('caissier-list-decaissement','Achat::decaissementListCaissierMain',['filter' => 'isLoggedIn']);
$routes->get('caissier-list-caissier','Achat::listCaissier',['filter' => 'isLoggedIn']);
$routes->get('caissier-encaissement-externe','Achat::getEncaissementExterne',['filter' => 'isLoggedIn']);
$routes->get('caissier-config-system','Dashboard::getConfigSystem',['filter' => 'isLoggedIn']);
