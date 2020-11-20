<?php

$routes->setDefaultNamespace('Modules\EndPoint\Controllers');
$routes->group('api/v1', function($routes){


  //ENDPOINT DE TABLES STATIQUES
  $routes->get('depot-get-all','TableStatique::depot_get');
  $routes->post('depot-create-one','TableStatique::depot_create');
  $routes->put('depot-get-update/(:num)/update','TableStatique::depot_update/$1');



  //ENDPOINTS LOGIQUES DATA
  //1.USERS
  $routes->get('users-get-all','Users::users_get');
  $routes->post('users-create-one','Users::users_create');
  $routes->get('users-get-all/(:num)/profile','Users::users_get_by_profile/$1');
  $routes->get('users-get-all-is-main-by-profile/(:num)/(:num)/is-main','Users::users_get_by_profile_is_main/$1/$2');



  //2.ARTCILES
  $routes->get('articles-get-all','Articles::articles_get');
  $routes->post('articles-create-one','Articles::articles_create');
  $routes->post('articles-create-price','Articles::articles_set_price');
  $routes->get('articles-search-data-commande/(:any)/(:num)/(:num)/search','Articles::article_search_data_commande/$1/$2/$3');
  $routes->get('articles-search-by-code/(:any)code','Articles::article_search_by_code/$1');
  $routes->post('articles-update-price','Articles::article_update_price');


  $routes->post('art-test','Articles::multitest');

  //2.COMMANDES
  $routes->get('commandes-get-all','Commandes::commandes_get');
  $routes->post('commandes-create','Commandes::commandes_create');
  $routes->get('commandes-get-all/(:num)/(:num)/facturier','Commandes::commandes_get_user_facturier/$1/$2');
  $routes->get('commandes-generate-code','Commandes::commande_generate_facture_code');
  $routes->get('commandes-get-all/(:num)/(:num)/caissier','Commandes::commandes_get_user_caissier/$1/$2');
  $routes->get('commandes-validation-caissier/(:any)/(:num)/(:num)/(:any)/validation','Commandes::validation_operation_commande_caissier/$1/$2/$3/$4');
  $routes->get('commandes-get-by-depot/(:num)/(:num)/depot','Commandes::commandes_get_by_depot/$1/$2');
  $routes->get('commandes-validation-magaz/(:any)/(:num)/(:num)/(:num)/validation','Commandes::validation_operation_commande_magasinier/$1/$2/$3/$4');
  $routes->get('commandes-all-by-status/(:num)/status','Commandes::commandes_all_get_by_status/$1');
  $routes->post('demande-negotiation','Commandes::commandes_negotiate');
  $routes->get('achat-get-all-negotiation/(:num)/negotiation','Commandes::commandes_get_en_negotiation/$1');
  $routes->post('achat-validate-negotiation','Commandes::commande_validate_negotiation');
  $routes->post('achat-annuler-tout-negotiation','Commandes::commande_tout_annuler_validate_negotiation');
  $routes->post('achat-annuler-selection-negotiation','Commandes::commande_annuler_selectionner_validate_negotiation');


  //3. APPROVISIONNEMENT
  $routes->get('approvisionnement-get-all/(:num)/(:num)','Approvisionnement::approvisionnement_get/$1/$2');
  $routes->post('approvisionnement-create','Approvisionnement::approvisionnement_create');


  //4. CAISSE ET ENCAISSEEMENT
  $routes->get('caisse-montant/(:num)','OperationCaisseEncaissement::getMontantCaisse/$1');
  $routes->get('get-all-decaissement/(:num)/(:num)/decaisse','OperationCaisseEncaissement::getDecaissementCaissierPrincipal/$1/$2');
  $routes->post('create-decaissement-solde','OperationCaisseEncaissement::createDecaissement');
  $routes->get('get-decaissement-par-caissier/(:num)','OperationCaisseEncaissement::getDecaissementParCaissier/$1');
  $routes->get('validation-decaissement/(:num)/(:num)/(:any)/validate','OperationCaisseEncaissement::validateDecaissement/$1/$2/$3');
  $routes->get('get-decaissement-externe-par-caissier/(:num)','OperationCaisseEncaissement::getDecaissementExterne/$1');
  $routes->post('create-decaissement--solde-externe','OperationCaisseEncaissement::createDecaissementExterne');


});
