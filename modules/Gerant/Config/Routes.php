<?php

$routes->setDefaultNamespace('Modules\Gerant\Controllers');
$routes->get('gerant-dashboard','Dashboard::index',['filter' => 'isLoggedIn']);
