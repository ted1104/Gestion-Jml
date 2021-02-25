<?php

$routes->setDefaultNamespace('Modules\Caisse\Controllers');
$routes->get('caissier-dashboard','Dashboard::index',['filter' => 'isCaissier']);
$routes->get('caissier-list-achat','Achat::index',['filter' => 'isCaissier']);
$routes->get('caissier-add-achat','Achat::achatCaissier',['filter' => 'isCaissier']);
$routes->get('caissier-add-decaissement','Achat::decaissementSend',['filter' => 'isCaissier']);
$routes->get('caissier-list-decaissement','Achat::decaissementListCaissierMain',['filter' => 'isCaissier']);
$routes->get('caissier-list-caissier','Achat::listCaissier',['filter' => 'isCaissier']);
$routes->get('caissier-encaissement-externe','Achat::getEncaissementExterne',['filter' => 'isCaissier']);
$routes->get('caissier-config-system','Dashboard::getConfigSystem',['filter' => 'isCaissier']);
