<?php

$routes->setDefaultNamespace('Modules\Gerant\Controllers');
$routes->get('gerant-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
$routes->get('gerant-achat-list','Dashboard::getAchatList',['filter' => 'isLoggedIn']);
$routes->get('gerant-stock','Dashboard::getStock',['filter' => 'isLoggedIn']);
$routes->get('gerant-histo-appro','Dashboard::getHistoriqueAppro',['filter' => 'isLoggedIn']);
$routes->get('gerant-histo-appro-inter-depot','Dashboard::getHistoriqueApproInterDepot',['filter' => 'isLoggedIn']);
$routes->get('gerant-config-system','Dashboard::getConfigSystem',['filter' => 'isLoggedIn']);
