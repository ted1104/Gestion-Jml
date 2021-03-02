<?php

$routes->setDefaultNamespace('Modules\EndPoint\Controllers');
$routes->group('api/v1', function($routes){


  //ENDPOINT DE TABLES STATIQUES
  $routes->get('depot-get-all','TableStatique::depot_get');
  $routes->post('depot-create-one','TableStatique::depot_create');
  $routes->put('depot-get-update/(:num)/update','TableStatique::depot_update/$1');
  $routes->get('stock-depot','TableStatique::getStockDepot');
  $routes->get('etat-critique','TableStatique::getEtatCritique');
  $routes->put('update-etat-critique','TableStatique::updateEtatCritique');
  $routes->get('stock-depot-by-depot/(:num)/depot','TableStatique::getStockDepotByDepot/$1');
  $routes->get('roles-get-all','TableStatique::getProfile');
  $routes->get('detect-etat-param-system','TableStatique::detectEtatDesParametresSysteme');


  //ENDPOINTS LOGIQUES DATA
  //1.USERS
  $routes->get('users-get-all/(:num)/(:num)','Users::users_get/$1/$2');
  $routes->post('users-create-one','Users::users_create');
  $routes->get('users-get-all/(:num)/profile','Users::users_get_by_profile/$1');
  $routes->get('users-get-all-is-main-by-profile/(:num)/(:num)/is-main','Users::users_get_by_profile_is_main/$1/$2');
  $routes->get('users-update-status-account/(:num)','Users::user_account_enable_disable/$1');
  $routes->get('users-reset-password/(:num)','Users::user_account_reset_password/$1');
  $routes->post('users-update-profile','Users::user_update_profile_picture');
  $routes->get('users-reset-password-connexion/(:num)/(:any)/(:any)/update','Users::user_account_reset_password_connexion/$1/$2/$3');
  $routes->get('users-reset-password-operation/(:num)/(:any)/(:any)/update','Users::user_account_reset_password_operation/$1/$2/$3');
  $routes->get('users-bloque-account','Users::bloqueAllCountUsers');
  $routes->get('users-debloque-account','Users::DebloqueAllCountUsers');
  $routes->get('users-change-pv-gestion-access/(:num)','Users::changeAccessToGestionPv/$1');
  $routes->get('users-change-achat-partiels-gestion-access/(:num)','Users::changeAccessToGestionAchatPartiels/$1');
  $routes->get('users-access-menu-system/(:num)','Users::changeAccessToSystemMenu/$1');
  $routes->get('users-access-system-cloture-stock/(:num)','Users::changeAccessToSystemClotureStock/$1');
  $routes->get('users-access-system-cloture-caisse/(:num)','Users::changeAccessToSystemClotureCaisse/$1');
  $routes->get('users-access-system-operation-comptes/(:num)','Users::changeAccessToSystemOperationCompte/$1');
  $routes->get('users-check-correct-password/(:num)/(:any)','Users::CheckIfPasswordIsCorrect/$1/$2');
  $routes->get('users-get-magaz-by-depot/(:num)','Users::users_get_magasinier_by_depot/$1');






  //2.ARTCILES
  $routes->get('articles-get-all/(:num)/(:num)','Articles::articles_get/$1/$2');
  $routes->post('articles-create-one','Articles::articles_create');
  $routes->post('articles-create-price','Articles::articles_set_price');
  $routes->get('articles-search-data-commande/(:any)/(:any)/(:num)/(:num)/search','Articles::article_search_data_commande/$1/$2/$3/$4');
  $routes->get('articles-search-by-code/(:any)code','Articles::article_search_by_code/$1');
  $routes->post('articles-update-price','Articles::article_update_price');
  $routes->get('articles-search-data-appro-inte-depot/(:any)/(:num)/(:num)/search','Articles::article_search_for_appro_inter_depot/$1/$2/$3');
  $routes->get('articles-delete-price/(:num)/del','Articles::article_delete_price/$1');
  $routes->post('articles-create-config-faveur','Articles::create_configuration_faveur_article');
  $routes->post('articles-update-configuration-faveur','Articles::article_configuration_faveur_article');
  $routes->get('article-change-visibilite-sur-rapport/(:num)','Articles::article_activate_visibilite_sur_rapport/$1');
  $routes->post('articles-set-kg-pv','Articles::article_set_kg_pv');
  $routes->put('update-article/(:num)/update','Articles::article_update/$1');


  $routes->post('art-test','Articles::multitest');

  //2.COMMANDES
  $routes->get('commandes-get-all','Commandes::commandes_get');
  $routes->post('commandes-create','Commandes::commandes_create');
  $routes->get('commandes-get-all/(:num)/(:num)/(:any)/(:num)/(:num)/facturier','Commandes::commandes_get_user_facturier/$1/$2/$3/$4/$5');
  $routes->get('commandes-generate-code','Commandes::commande_generate_facture_code');
  $routes->get('commandes-get-all/(:num)/(:num)/(:any)/(:num)/(:num)/caissier','Commandes::commandes_get_user_caissier/$1/$2/$3/$4/$5');
  $routes->get('commandes-validation-caissier/(:any)/(:num)/(:num)/(:any)/validation','Commandes::validation_operation_commande_caissier/$1/$2/$3/$4');
  $routes->get('commandes-get-by-depot/(:num)/(:num)/(:any)/(:num)/(:num)/(:num)/depot','Commandes::commandes_get_by_depot/$1/$2/$3/$4/$5/$6');
  $routes->get('commandes-validation-magaz/(:any)/(:num)/(:num)/(:num)/validation','Commandes::validation_operation_commande_magasinier/$1/$2/$3/$4');
  $routes->get('commandes-all-by-status/(:num)/(:any)/(:num)/(:num)/(:num)/status','Commandes::commandes_all_get_by_status/$1/$2/$3/$4/$5');
  $routes->post('demande-negotiation','Commandes::commandes_negotiate');
  $routes->get('achat-get-all-negotiation/(:num)/negotiation','Commandes::commandes_get_en_negotiation/$1');
  $routes->post('achat-validate-negotiation','Commandes::commande_validate_negotiation');
  $routes->post('achat-annuler-tout-negotiation','Commandes::commande_tout_annuler_validate_negotiation');
  $routes->post('achat-annuler-selection-negotiation','Commandes::commande_annuler_selectionner_validate_negotiation');
  $routes->get('commandes-get-all-search/(:num)/(:num)/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)/facturier','Commandes::search_commandes_get_user_facturier/$1/$2/$3/$4/$5/$6/$7/$8');
  $routes->get('commandes-get-all-search/(:num)/(:num)/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)/caissier','Commandes::search_commandes_get_user_caissier/$1/$2/$3/$4/$5/$6/$7/$8');
  $routes->get('commandes-get-by-depot-search/(:num)/(:num)/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)/depot','Commandes::search_commandes_get_by_depot/$1/$2/$3/$4/$5/$6/$7/$8');
  $routes->get('commandes-all-by-status-search/(:num)/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)/status','Commandes::search_commandes_all_get_by_status/$1/$2/$3/$4/$5/$6/$7');
  $routes->post('achat-annuler','Commandes::annuler_commande_achat');
  $routes->post('commandes-validation-magaz-partielle','Commandes::validation_operation_commande_magasinier_partiellement');
  $routes->get('commandes-faveur-get-by-depot/(:num)/(:num)/(:any)/depot','Commandes::commandes_faveurs_get_by_depot/$1/$2/$3');
  $routes->get('commandes-faveur-get-by-depot-search/(:num)/(:num)/(:any)/(:any)/(:num)/(:num)/(:num)/(:num)/depot','Commandes::search_commandes_faveur_get_by_depot/$1/$2/$3/$4/$5/$6/$7/$8');
  $routes->post('delete-article-commande','Commandes::commandes_delete_articles');
  $routes->get('achat-last-one-facturier/(:num)','Commandes::commandes_get_user_facturier_last_one/$1');


  //3. APPROVISIONNEMENT
  $routes->get('approvisionnement-get-all/(:any)/(:num)/(:num)','Approvisionnement::approvisionnement_get/$1/$2/$3');
  $routes->get('approvisionnement-get-by-depot/(:num)/(:num)/(:num)/(:any)','Approvisionnement::approvisionnement_get_by_depot/$1/$2/$3/$4');
  $routes->post('approvisionnement-create','Approvisionnement::approvisionnement_create');
  $routes->get('approvisionnement-inter-depot-get-all/(:num)/(:num)/(:any)','ApprovisionnementInterDepot::approvisionnementInterDepot_get/$1/$2/$3');
  $routes->post('approvisionnement-inter-depot-create','ApprovisionnementInterDepot::approvisionnementInterDepot_create');
  $routes->get('approvisionnement-inter-depot-get-by-depot/(:num)/(:num)/(:num)/(:any)','ApprovisionnementInterDepot::approvisionnementInterDepot_get_by_depot/$1/$2/$3/$4');
  $routes->get('approvisionnement-inter-depot-validate/(:any)/(:num)/(:num)/validate','ApprovisionnementInterDepot::validateApprovisionnementInterDepot/$1/$2/$3');
  $routes->post('approvisionnement-annuler','ApprovisionnementInterDepot::annuler_approvisionnement_inter_depot');
  $routes->post('delete-article-approvisionnement','ApprovisionnementInterDepot::approvisionnement_delete_articles');
  $routes->post('pv-approvisionnement-restaure','Approvisionnement::approvisionementPvRestaure');
  $routes->post('validate-partiel-article-approvisionnement','ApprovisionnementInterDepot::approvisionnement_validate_partiel_articles');
  $routes->get('ajustement-stock-depot-virtuelle-reelle/(:num)/(:num)/(:any)/(:any)','Approvisionnement::ajustementStockDepot/$1/$2/$3/$4');



  //CLOTURE AUTOMATIQUE
  $routes->get('cloture-stock-journalier','Approvisionnement::clotureJournalierStock');
  $routes->get('cloture-caisse-journalier','OperationCaisseEncaissement::clotureJournalierCaisse');



  //4. CAISSE ET ENCAISSEEMENT
  $routes->get('caisse-montant/(:num)','OperationCaisseEncaissement::getMontantCaisse/$1');
  $routes->get('get-all-decaissement/(:num)/(:num)/(:any)/decaisse','OperationCaisseEncaissement::getDecaissementCaissierPrincipal/$1/$2/$3');
  $routes->post('create-decaissement-solde','OperationCaisseEncaissement::createDecaissement');
  $routes->get('get-decaissement-par-caissier/(:num)','OperationCaisseEncaissement::getDecaissementParCaissier/$1');
  $routes->get('validation-decaissement/(:num)/(:num)/(:any)/validate','OperationCaisseEncaissement::validateDecaissement/$1/$2/$3');
  $routes->get('get-decaissement-externe-par-caissier/(:num)/(:any)','OperationCaisseEncaissement::getDecaissementExterne/$1/$2');
  $routes->post('create-decaissement--solde-externe','OperationCaisseEncaissement::createDecaissementExterne');
  $routes->get('get-all-encaissement-externe/(:num)/(:any)/enc','OperationCaisseEncaissement::getEncaissementExterne/$1/$2');
  $routes->post('create-encaissement-externe','OperationCaisseEncaissement::createEncaissementExterne');

  //5. STOCK PERSONNEL !!!!==!!!!
  $routes->get('injection-manuelle-stock-personnel','StockPersonnel::injectStockPersonnelManuel');
  $routes->get('articles-search-data-transfert/(:any)/(:num)/(:num)/search','Articles::article_search_for_transfert/$1/$2/$3');

  //TRANSFERT STOCK INTER MAGASININIER
  $routes->post('transfert-create','TransfertStockDepot::transfert_create');
  $routes->get('transfert-magaz-get-by-magaz/(:num)/(:num)/(:num)/(:any)','TransfertStockDepot::transfert_get_by_depot/$1/$2/$3/$4');




});
