<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\I18n\Time;

use App\Entities\CommandesEntity;
use App\Entities\AretirerEntity;
use App\Models\CommandesDetailModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\UsersAuthModel;
use App\Models\EncaissementModel;
use App\Models\CaisseModel;
use App\Models\StockModel;
use App\Models\StockPersonnelModel;
use App\Models\AretirerModel;



class Commandes extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\CommandesModel';
  protected $commandesStatusHistoriqueModel = null;
  protected $usersAuthModel = null;
  protected $encaissementModel = null;
  protected $caisseModel = null;
  protected $commandesDetailModel = null;
  protected $stockModel = null;
  protected $stockPersonnelModel = null;
  protected $aretirerModel = null;

  public function __construct(){
    helper(['global']);
    $this->commandesDetailModel = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->usersAuthModel = new UsersAuthModel();
    $this->encaissementModel = new EncaissementModel();
    $this->caisseModel = new CaisseModel();
    $this->stockModel = new StockModel();
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->aretirerModel = new AretirerModel();
  }
  public function commandes_get(){
    $data = $this->model->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function commandes_create(){

    $this->model->beginTrans();
    $data = new CommandesEntity($this->request->getPost());
    if(!$insertData = $this->model->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      //CREATE DETAIL ARTICLE VENDU
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte_vendue = $data->qte_vendue;
      $prix_unitaire = $data->prix_unitaire;
      $is_faveur = $data->is_faveur;
      $prix_transport = $data->prix_transport;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'vente_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte_vendue'=>$qte_vendue[$i],
          'prix_unitaire' =>$prix_unitaire[$i],
          'prix_transport' =>$data->is_transported ==1 ? $prix_transport[$i] : 0,
          'is_faveur' => $is_faveur[$i],
          'is_validate_livrer'=>0
        ];
        // print_r($dataDetail);
        // exit();
        $this->commandesDetailModel->insert($dataDetail);
      }
      //CREATE HISTO STATUS
      $dataStatusHistorique=[
          'vente_id' => $insertData,
          'status_vente_id' => 1,
          'users_id' => $this->request->getPost('users_id'),
      ];
      $this->commandesStatusHistoriqueModel->insert($dataStatusHistorique);
      $status = 200;
      $message = [
        'success' => 'La commande a été effectuée avec succès',
        'errors' => null
      ];
      $data = 'null';
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function commande_generate_facture_code(){
    $uniqueAchatID = $this->model->createUniqueAchatID();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $this->model->checkIfUniqueAchatIDExist($uniqueAchatID),
      'depot_central' => getDepotCentral(1)
    ]);
  }
  //LISTE DE COMMANDE PAR UTILISATEUR FACTURIER : DONC LES COMMANDES CREES PAR UN FACTURIER
  public function commandes_get_user_facturier($iduser,$statutVente,$dateFilter,$limit,$offset){
    $d = Time::today();
    if($dateFilter == "null"){
      $dateFilter = $d;
    }
    $condition =['date_vente'=> $dateFilter];
    $data = $this->model->Where($condition)->Where('users_id',$iduser)->where('status_vente_id',$statutVente)->orderBy('id','DESC')->findAll($limit,$offset);
    header('Content-Type: application/json');
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> $this->model->selectCount('id')->Where($condition)->Where('users_id',$iduser)->where('status_vente_id',$statutVente)->orderBy('id','DESC')->findAll()[0]->id,
      'nombreVenteType' => $this->commandeByTypeByuser($iduser,'users_id',$condition),

    ]);
  }

  //RETOURNE LA DERNIERE COMMANDE CREER PAR UN FACTURIER USAGE PRINTING
  public function commandes_get_user_facturier_last_one($iduser){
    $data = $this->model->Where('users_id',$iduser)->orderBy('id','DESC')->first();

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => [
        'code' =>$data?$data->id:0,
        'numero' =>$data?$data->numero_commande:0
      ],
    ]);
  }

  //FONCTION COMPLEMENTAIRE DE POUR GET LE NOMBRES DES COMMANDES SELON LE USER OU TYPE DU USE OU TYPE DE COMMANDES
  public function commandeByTypeByuser($iduser,$nomchamps,$condition){
    return $array =[
      'attente'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',1)->findAll()),
      'payer'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',2)->findAll()),
      'livrer'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',3)->findAll()),
      'annuler'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',4)->findAll()),
      'delete'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',5)->findAll()),
    ];

  }

  //LISTE DE COMMANDE PAR UTILISATEUR CAISSIER : DONC LES COMMANDES CREES PAR UN FACTURIER
  public function commandes_get_user_caissier($iduser,$statutVente,$dateFilter,$limit,$offset){
    $d = Time::today();
    if($dateFilter == "null"){
      $dateFilter = $d;
    }
    $condition =['date_vente'=> $dateFilter];
    $data = $this->model->orderBy('id','DESC')->Where($condition)->Where('payer_a',$iduser)->where('status_vente_id',$statutVente)->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> $this->model->selectCount('id')->Where($condition)->Where('payer_a',$iduser)->where('status_vente_id',$statutVente)->orderBy('id','DESC')->findAll()[0]->id,
      'nombreVenteType' => $this->commandeByTypeByuser($iduser,'payer_a',$condition)
    ]);
  }

  //FONCTION VALIDATION OPERATION PAR CAISSIER DONC VALIDATION DU PAYEMENT
  public function validation_operation_commande_caissier($pwd,$idcommande,$iduser,$somme){
    $infoCommande = $this->model->find($idcommande);
    // print_r($infoCommande->depots_id[0]->id);
    // die();

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      //SUITES VALIDATIONS
      if(!$this->model->checkingIfOneArticleHasNotEnoughtQuanityVirtuelle($infoCommande->depots_id[0]->id,$idcommande)){
      $data = ['status_vente_id'=>2];
      if(!$updateData = $this->model->update($idcommande,$data)){
        $status = 400;
        $message = [
          'success' => null,
          'errors' => $this->model->erros()
        ];
        $data = "";
      }else {
        //CREATION HISTORIQUE CHANGEMENT STATUS
        $dataStatusHistorique=[
            'vente_id' => $idcommande,
            'status_vente_id' => 2,
            'users_id' => $iduser,
        ];
        if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
          //CREATION DETAIL ENCAISSMENT
          $dataEncaissement = [
            'vente_id' =>$idcommande,
            'users_id' =>$iduser,
            'montant_encaissement' =>$somme,
          ];
          if($this->encaissementModel->insert($dataEncaissement)){

            $userExistCaisse = $this->caisseModel->Where('users_id',$iduser)->findAll();
            if($userExistCaisse){
              $nvo = $userExistCaisse[0]->montant + $somme;
              $this->caisseModel->update($userExistCaisse[0]->id, ['montant'=>$nvo]);
            }else{
              $dataCaisse = [
                'users_id'=>$iduser,
                'montant' => $somme
              ];
              $insertData = $this->caisseModel->insert($dataCaisse);
            }

            //DECOMPTE DE LA QUANTITE VIRTUELLE DU DEPOT SPECIFIQUE
            $infoCommande = $this->model->find($idcommande);
            $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->findAll();
            foreach ($allArt as $key => $value) {

            // if($value->is_faveur == 0){
            $stokdepot = $this->stockModel->getWhere(['depot_id'=>$infoCommande->depots_id[0]->id,'articles_id'=>$value->articles_id[0]->id])->getRow();
            // }else{
            //   $stokdepot = $this->stockModel->getWhere(['depot_id'=>$infoCommande->depots_id_faveur,'articles_id'=>$value->articles_id[0]->id])->getRow();
            // }

            $stokinit = $stokdepot->qte_stock_virtuel;
            $qte_a_retrancher = $value->qte_vendue;
            $nvlleqte = $stokinit-$qte_a_retrancher;
            $this->stockModel->update($stokdepot->id,['qte_stock_virtuel'=>$nvlleqte]);
            }
            //FIN DECOMPTE DE LA QUANTITE VIRTUELLE DU DEPOT SPECIFIQUE
            $status = 200;
            $message = [
              'success' => 'Validation du payement reussi',
              'errors' => null
            ];
            $data = "";

          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => $this->encaissementModel->erros()
            ];
            $data = "";
          }
        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => $this->commandesStatusHistoriqueModel->erros()
          ];
          $data = "";
        }
      }
    }else{
        $status = 401;
        $message = [
          'success' => null,
          'errors' => ['Impossible d\'executer cet achat vu que ce dépôt ne possède pas une quantité suffisante pour certains articles! Consulter le détail de l\'achat et tous les articles avec un point rouge cad cette quantité n\'est plus en stock']
        ];
        $data = "";
      }
    }
    // $this->model->RollbackTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR AFFICHER LES COMMANDES AFFECTER A UN DEPOT SPECIFIQUE
  public function commandes_get_by_depot($iddepot,$statutVente,$dateFilter,$limit,$offset,$isPartiel,$isAretirer){
    $d = Time::today();
    $d = explode(' ',$d);
    $d = $d[0];
    if($dateFilter == "null"){
      $dateFilter = $d;
    }
    $condition =['date_vente'=> $dateFilter];
    $conditionAllAchatFaveur = [];
    if(getTypeDepot($iddepot)){
      $conditionAllAchatFaveur = ['container_faveur' => 1];
    }
    $conditionPartiel = [];

    if($isPartiel == 1){
      $conditionPartiel = ['is_livrer_all'=>1];
      if($dateFilter == $d){
        $condition =[];
      }
    }


    $data = $this->model->orderBy('id','DESC')->Where($condition)->Where('depots_id',$iddepot)->Where('status_vente_id',$statutVente)->Where($conditionPartiel)->findAll($limit,$offset);


    if($isAretirer ==1){
      $conditionDate =['date_vente'=> $dateFilter];
      if($dateFilter == $d){
          $conditionDate =[];
      }

      $dataAnc = $this->model->select("*, g_interne_vente.id, g_interne_vente.created_at")->distinct('')->join('g_interne_vente_detail','g_interne_vente_detail.vente_id=g_interne_vente.id','right')->join('g_interne_a_retirer','g_interne_a_retirer.vente_detail_id=g_interne_vente_detail.id','right')->orderBy('g_interne_vente.id','DESC')->groupBy('g_interne_vente.numero_commande')->Where('depots_id',$iddepot)->Where('g_interne_vente.status_vente_id',$statutVente)->Where($conditionDate)->findAll($limit,$offset);

      $dataCount = $this->model->select("*, g_interne_vente.id,g_interne_vente.created_at")->distinct('')->join('g_interne_vente_detail','g_interne_vente_detail.vente_id=g_interne_vente.id','right')->join('g_interne_a_retirer','g_interne_a_retirer.vente_detail_id=g_interne_vente_detail.id','right')->orderBy('g_interne_vente.id','DESC')->groupBy('g_interne_vente.numero_commande')->Where('depots_id',$iddepot)->Where('g_interne_vente.status_vente_id',$statutVente)->Where($conditionDate)->findAll();


      $data = $dataAnc;

    }



    // print_r(count($data));
    // die();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> $isAretirer ==0 ? $this->model->selectCount('id')->Where($condition)->Where('depots_id',$iddepot)->where('status_vente_id',$statutVente)->Where($conditionPartiel)->orderBy('id','DESC')->findAll()[0]->id : count($dataCount),
      'nombreVenteType' => $this->commandeByTypeByuser($iddepot,'depots_id',$condition)
    ]);
  }

  //FONCTION POUR AFFICHER LES COMMANDES FAVEURS AFFECTER A UN DEPOT CENTRAL
  public function commandes_faveurs_get_by_depot($iddepot,$statutVente,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){
      $dateFilter = $d;
    }
    $condition =['date_vente'=> $dateFilter];
    $conditionAllAchatFaveur = ['container_faveur' => 1];
    $conditionDepotCentralTraiteurFaveur = ['depots_id_faveur' => $iddepot];
    $data = $this->model->orderBy('id','DESC')->Where($condition)->Where($conditionDepotCentralTraiteurFaveur)->Where($conditionAllAchatFaveur)->where('status_vente_id',$statutVente)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuserFaveur($iddepot,'depots_id_faveur',$condition,$conditionAllAchatFaveur)
    ]);
  }

  public function commandeByTypeByuserFaveur($iduser,$nomchamps,$condition,$conditionAllAchatFaveur){
    return $array =[
      'attente'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',1)->Where($conditionAllAchatFaveur)->findAll()),
      'payer'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',2)->Where($conditionAllAchatFaveur)->findAll()),
      'livrer'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',3)->Where($conditionAllAchatFaveur)->findAll()),
      'annuler'=>count($this->model->orderBy('id','DESC')->Where($condition)->Where($nomchamps,$iduser)->Where('status_vente_id',4)->Where($conditionAllAchatFaveur)->findAll()),
    ];

  }

  //FONCTION POUR VALIDATION LIVRAISON COMMANDE MAGAZINIER
  public function validation_operation_commande_magasinier($pwd,$idcommande,$iduser,$iddepot){

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      $infoCommande = $this->model->find($idcommande);
      // if($infoCommande->container_faveur ==1){
      //   //ACHAT FAVEUR ET DEPOT CENTRAL VALIDATION
      //   if(getTypeDepot($iddepot)){
      //     //VALIDATION DEPOT CENTRAL
      //     //Check if all isNotFaveur are isLivrer
      //     $allIsNotFaveur = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',0)->findAll();
      //     $allIsNotFaveurAnLivrer = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',0)->Where('is_livrer',1)->findAll();
      //     if(count($allIsNotFaveur) == count($allIsNotFaveurAnLivrer)){
      //       //MEANS all not Faveur are delivred
      //       $data = ['status_vente_id'=>3];
      //       if(!$updateData = $this->model->update($idcommande,$data)){
      //         $status = 400;
      //         $message = [
      //           'success' => null,
      //           'errors' => $this->model->erros()
      //         ];
      //         $data = "";
      //       }else {
      //         if(!$this->commandesDetailModel->set('is_livrer',1)->Where('vente_id',$idcommande)->Where('is_faveur',1)->update()){
      //           $status = 400;
      //           $message = [
      //             'success' => null,
      //             'errors' => 'Echec de livraison, contactez l\'administrateur principal'
      //           ];
      //           $data = "";
      //         }else{
      //           $dataStatusHistorique=[
      //               'vente_id' => $idcommande,
      //               'status_vente_id' => 3,
      //               'users_id' => $iduser,
      //           ];
      //           if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
      //             //DECOMPTE DU STOCK DEOPOTS
      //             $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',1)->findAll();
      //             foreach ($allArt as $key => $value) {
      //               $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
      //               $stokinit = $stokdepot->qte_stock;
      //               $qte_a_retrancher = $value->qte_vendue;
      //               $nvlleqte = $stokinit-$qte_a_retrancher;
      //               $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
      //             }
      //             $status = 200;
      //             $message = [
      //               'success' => 'Livraison effectué avec succès',
      //               'errors' => null
      //             ];
      //             $data = "";
      //           }
      //         }
      //       }
      //     }else{
      //       //WHEN NO DELIVERY YET
      //       $dataUpdate = ['is_livrer' => 1];
      //       $dataUpt = ['depots_id_first_livrer' => $iddepot];
      //       $upDetailCommande = $this->commandesDetailModel->set('is_livrer',1)->Where('vente_id',$idcommande)->Where('is_faveur',1)->update();
      //       $upCommandeFirstDepotLivrer = $this->model->set('depots_id_first_livrer',$iddepot)->Where('id',$idcommande)->update();
      //       if(!$upDetailCommande and !$upCommandeFirstDepotLivrer){
      //         $status = 400;
      //         $message = [
      //           'success' => null,
      //           'errors' => 'Echec de livraison, contactez l\'administrateur principal'
      //         ];
      //         $data = "";
      //       }else{
      //         $dataStatusHistorique=[
      //             'vente_id' => $idcommande,
      //             'status_vente_id' => 3,
      //             'users_id' => $iduser,
      //         ];
      //         if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
      //           //DECOMPTE DU STOCK DEOPOTS
      //           $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',1)->findAll();
      //           foreach ($allArt as $key => $value) {
      //             $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
      //             $stokinit = $stokdepot->qte_stock;
      //             $qte_a_retrancher = $value->qte_vendue;
      //             $nvlleqte = $stokinit-$qte_a_retrancher;
      //             $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
      //           }
      //           $status = 200;
      //           $message = [
      //             'success' => 'Livraison d\'une partie de l\'achat a été effectué avec succès',
      //             'errors' => null
      //           ];
      //           $data = "";
      //
      //         }
      //       }
      //
      //     }
      //
      //   }else{
      //     //VALIDATION DEPOT SECONDAIRE
      //     //Check if all isNotFaveur are isLivrer
      //     $allIsNotFaveur = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',1)->findAll();
      //     $allIsNotFaveurAnLivrer = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',1)->Where('is_livrer',1)->findAll();
      //     if(count($allIsNotFaveur) == count($allIsNotFaveurAnLivrer)){
      //       //MEAN ALL FAVEUR ARE delivred
      //       $data = ['status_vente_id'=>3];
      //       if(!$updateData = $this->model->update($idcommande,$data)){
      //         $status = 400;
      //         $message = [
      //           'success' => null,
      //           'errors' => $this->model->erros()
      //         ];
      //         $data = "";
      //       }else {
      //         if(!$this->commandesDetailModel->set('is_livrer',1)->Where('vente_id',$idcommande)->Where('is_faveur',0)->update()){
      //           $status = 400;
      //           $message = [
      //             'success' => null,
      //             'errors' => 'Echec de livraison, contactez l\'administrateur principal'
      //           ];
      //           $data = "";
      //         }else{
      //           $dataStatusHistorique=[
      //               'vente_id' => $idcommande,
      //               'status_vente_id' => 3,
      //               'users_id' => $iduser,
      //           ];
      //           if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
      //             //DECOMPTE DU STOCK DEOPOTS
      //             $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',0)->findAll();
      //             foreach ($allArt as $key => $value) {
      //               $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
      //               $stokinit = $stokdepot->qte_stock;
      //               $qte_a_retrancher = $value->qte_vendue;
      //               $nvlleqte = $stokinit-$qte_a_retrancher;
      //               $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
      //             }
      //             $status = 200;
      //             $message = [
      //               'success' => 'Livraison effectué avec succès',
      //               'errors' => null
      //             ];
      //             $data = "";
      //
      //           }
      //         }
      //       }
      //     }else{
      //       //WHEN NO DELIVERY YET
      //       $upDetailCommande = $this->commandesDetailModel->set('is_livrer',1)->Where('vente_id',$idcommande)->Where('is_faveur',0)->update();
      //       $upCommandeFirstDepotLivrer = $this->model->set('depots_id_first_livrer',$iddepot)->Where('id',$idcommande)->update();
      //       if(!$upDetailCommande and !$upCommandeFirstDepotLivrer){
      //         $status = 400;
      //         $message = [
      //           'success' => null,
      //           'errors' => 'Echec de livraison, contactez l\'administrateur principal'
      //         ];
      //         $data = "";
      //       }else{
      //         $dataStatusHistorique=[
      //             'vente_id' => $idcommande,
      //             'status_vente_id' => 3,
      //             'users_id' => $iduser,
      //         ];
      //         if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
      //           //DECOMPTE DU STOCK DEOPOTS
      //           $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_faveur',0)->findAll();
      //           foreach ($allArt as $key => $value) {
      //             $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
      //             $stokinit = $stokdepot->qte_stock;
      //             $qte_a_retrancher = $value->qte_vendue;
      //             $nvlleqte = $stokinit-$qte_a_retrancher;
      //             $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
      //           }
      //           $status = 200;
      //           $message = [
      //             'success' => 'Livraison d\'une partie de l\'achat a été effectué avec succès',
      //             'errors' => null
      //           ];
      //           $data = "";
      //
      //         }
      //       }
      //     }
      //   }
      //
      // }else {
        //ACHAT ET VALIDATION NORMAL
        if(!$this->model->checkingIfOneArticleHasNotEnoughtQuanity($iddepot,$idcommande)){
          //SUITES VALIDATIONS
          $data = ['status_vente_id'=>3,'is_livrer_all'=>2];
          // $this->model->beginTrans();
          if(!$updateData = $this->model->update($idcommande,$data)){
            $status = 400;
            $message = [
              'success' => null,
              'errors' => $this->model->erros()
            ];
            $data = "";
          }else {
            //CREATION HISTORIQUE CHANGEMENT STATUS
            $dataStatusHistorique=[
                'vente_id' => $idcommande,
                'status_vente_id' => 3,
                'users_id' => $iduser,
            ];
            //CHECK IF HISTORIQUE ALREADY EXIST
            // $insertHisto = true;
            // if(!$this->commandesStatusHistoriqueModel->Where('vente_id',$idcommande)->Where('status_vente_id',3)->find()){
            //   $insertHisto = $this->commandesStatusHistoriqueModel->insert($dataStatusHistorique);
            // }
            if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){

              //DECOMPTE DU STOCK DEOPOTS
              $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->where('is_validate_livrer',0)->findAll();
              foreach ($allArt as $key => $value) {
                $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
                $stokinit = $stokdepot->qte_stock;
                $qte_a_retrancher = $value->qte_vendue;
                $nvlleqte = $stokinit-$qte_a_retrancher;
                $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
                $this->commandesDetailModel->update($value->id, ['is_validate_livrer'=>1,'livrer_by'=>$iduser]);

                //DECOMPTE STOCK PERSONNEL LORS DE LA VALIDATION ACHAT
                $this->stockPersonnelModel->updateQtePersonnel($iduser, $value->articles_id[0]->id, $qte_a_retrancher,0);

                // //CREATE HISTORIQUE A RETIRER
                // $data = ['vente_detail_id'=>$value->id,'qte_restante'=>0,'users_id'=>$iduser];
                // $this->aretirerModel->insert($data);
                // // print_r($this->aretirerModel->insert($data));
                // // die();



              }
              $status = 200;
              $message = [
                'success' => 'Livraison effectué avec succès',
                'errors' => null
              ];
              $data = "";

            }else{
              $status = 400;
              $message = [
                'success' => null,
                'errors' => $this->commandesStatusHistoriqueModel->erros()
              ];
              $data = "";
            }
          }
        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => ['Impossible d\'executer cet achat vu que vous n\'avez pas une quantité suffisante pour certains articles! Consulter le détail de l\'achat']
          ];
          $data = "";
        }
      //}
      }

    // $this->model->RollbackTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  public function validation_operation_commande_magasinier_partiellement(){
    $pwd = $this->request->getPost('pwd');
    $idcommande = $this->request->getPost('idcommande');
    $iduser = $this->request->getPost('iduser');
    $iddepot = $this->request->getPost('iddepot');
    $idarticle = $this->request->getPost('idarticle'); // un tableau d'article

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      if(!$this->model->checkingIfOneArticleHasNotEnoughtQuanityPartiel($iddepot,$idcommande,$idarticle)){
        $getAllArticleInCommande = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('is_validate_livrer',0)->findAll();
        $data = ['status_vente_id'=>3,'is_livrer_all'=>1];
        if(count($idarticle) < count($getAllArticleInCommande)){
          if(!$this->model->update($idcommande,$data)){
            $status = 400;
            $message = [
              'success' => null,
              'errors' => $this->model->erros()
            ];
            $data = "";
          }else {
            //CREATION HISTORIQUE CHANGEMENT STATUS
            $dataStatusHistorique=[
                'vente_id' => $idcommande,
                'status_vente_id' => 3,
                'users_id' => $iduser,
            ];
            //CHECK IF HISTORIQUE ALREADY EXIST
            // $insertHisto = true;
            // if(!$this->commandesStatusHistoriqueModel->Where('vente_id',$idcommande)->Where('status_vente_id',3)->find()){
            //   $insertHisto = $this->commandesStatusHistoriqueModel->insert($dataStatusHistorique);
            // }
            if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
              //DECOMPTE DU STOCK DEOPOTS
              // $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->findAll();
              for ($i=0; $i < count($idarticle); $i++) {
                $detArticleAchat = $this->commandesDetailModel->Where('vente_id',$idcommande)->Where('articles_id',$idarticle[$i])->findAll();

                $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$idarticle[$i]])->getRow();
                $stokinit = $stokdepot->qte_stock;
                $qte_a_retrancher = $detArticleAchat[0]->qte_vendue;
                $nvlleqte = $stokinit-$qte_a_retrancher;
                $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
                $this->commandesDetailModel->update($detArticleAchat[0]->id, ['is_validate_livrer'=>1,'livrer_by'=>$iduser]);

                //DECOMPTE STOCK PERSONNEL LORS DE LA VALIDATION ACHAT
                $this->stockPersonnelModel->updateQtePersonnel($iduser, $idarticle[$i], $qte_a_retrancher,0);

                // //CREATE HISTORIQUE A RETIRER
                // $data = ['vente_detail_id'=>$detArticleAchat[0]->id,'qte_restante'=>0,'users_id'=>$iduser];
                // $this->aretirerModel->insert($data);
                // // print_r($this->aretirerModel->insert($data));
                // // die();


              }
              $status = 200;
              $message = [
                'success' => 'Livraison effectué partiellement avec succès',
                'errors' => null
              ];
              $data = "";

            }else{
              $status = 400;
              $message = [
                'success' => null,
                'errors' => $this->commandesStatusHistoriqueModel->erros()
              ];
              $data = "";
            }

          }

        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => ['Impossible de livrer tous les articles de cet achat, veuillez par contre valider tout l\'achat dans son ensemble!']
          ];
          $data = "";
        }


      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => ['Impossible d\'executer cet achat vu que vous n\'avez pas une quantité suffisante pour certains articles selectionnés! Consulter le détail de l\'achat']
        ];
        $data = "";
      }

    }

    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR DEMANDE UNE NEGOTIATION
  public function commandes_negotiate(){
    $idcommande = $this->request->getPost('idcommande');
    $idarticle = $this->request->getPost('idarticle');

    for ($i=0; $i < count($idarticle); $i++) {
      if($this->model->update(['id'=>$idcommande],['is_negotiate'=>1])){
        $condition = [
          'vente_id' =>$idcommande,
          'articles_id'=>$idarticle[$i]
        ];
        $data = $this->commandesDetailModel->getWhere($condition)->getRow();
        if($this->commandesDetailModel->update($data->id,['is_negotiate'=>1])){
          $status = 200;
          $message = [
            'success' => 'La Négociation a été envoyée et reste en attente de validation',
            'errors' => null
          ];
          $data = "";

        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => "Echec demande negotiation article detail"
          ];
          $data = "";
        }

      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => "Echec demande negotiation achat"
        ];
        $data = "";
      }
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR SUPPRIMER ARTICLE SUR UNE COMMANDE
  public function commandes_delete_articles(){
    $idcommande = $this->request->getPost('idcommande');
    $idarticle = $this->request->getPost('idarticle');

    if($this->model->find($idcommande)->status_vente_id->id==1){
      $getAllarticleDeLaCommande = $this->commandesDetailModel->Where('vente_id', $idcommande)->findAll();
      if(count($idarticle) < count($getAllarticleDeLaCommande)){
      for ($i=0; $i < count($idarticle); $i++) {
          $condition = [
            'vente_id' =>$idcommande,
            'articles_id'=>$idarticle[$i]
          ];
          $data = $this->commandesDetailModel->getWhere($condition)->getRow();
          if($this->commandesDetailModel->delete(['id' =>$data->id ])){
            $textArt = $i > 1 ? 'ont':'a';
            $status = 200;
            $message = [
              'success' => ($i+1).' article(s) de cet achat '.$textArt.' été supprimer avec succès',
              'errors' => null
            ];
            $data = "";

          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => "Echec de la suppression d'article"
            ];
            $data = "";
          }

        }
      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => ['Impossible de supprimer tous les articles de l\'achat!']
        ];
        $data = "";
      }
    }else{
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ['Impossible de supprimer les articles car cette facture est déjà payée ou livrée!']
      ];
      $data = "";
    }

    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR VALIDER UNE NEGOTIATION
  public function commande_validate_negotiation(){
    $idcommande = $this->request->getPost('idcommande');
    $idarticle = $this->request->getPost('idarticle');
    $idcaissier = $this->request->getPost('idcaissier');
    $montantNegocier = $this->request->getPost('montant');
    $up = $this->model->update(['id'=>$idcommande],['is_negotiate'=>2,'payer_a'=>$idcaissier]);
    for ($i=0; $i < count($idarticle); $i++) {
      if($up){
        $condition = [
          'vente_id' =>$idcommande,
          'articles_id'=>$idarticle[$i]
        ];
        $data = $this->commandesDetailModel->getWhere($condition)->getRow();
        if($this->commandesDetailModel->update($data->id,['is_negotiate'=>2,'prix_negociation'=>$montantNegocier[$i]])){
          $status = 200;
          $message = [
            'success' => 'La Négociation validée',
            'errors' => null
          ];
          $data = "";

        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => "Echec demande negotiation article detail"
          ];
          $data = "";
        }

      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => "Echec demande negotiation achat"
        ];
        $data = "";
      }
    }

    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR ANNULER LA NEGOTIATION TOUT COTE ADMINISTRATION
  public function commande_tout_annuler_validate_negotiation(){
    $idcommande = $this->request->getPost('idcommande');
    // $idarticle = $this->request->getPost('idarticle');
      if($this->model->update(['id'=>$idcommande],['is_negotiate'=>1])){
        $condition = [
          'vente_id' =>$idcommande,
        ];
        $data = $this->commandesDetailModel->getWhere($condition)->getResult();
        foreach ($data as $key => $value) {
          if($this->commandesDetailModel->update($value->id,['is_negotiate'=>1,'prix_negociation'=>NULL])){
            $status = 200;
            $message = [
              'success' => 'La Négociation a été annulée',
              'errors' => null
            ];
            $data = "";

          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => "Echec demande negotiation article detail"
            ];
            $data = "";
          }
        }
      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => "Echec demande negotiation achat"
        ];
        $data = "";
      }


    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR ANNULER LA NEGOTIATION SELECTIONNER COTE ADMINISTRATION
  public function commande_annuler_selectionner_validate_negotiation(){
    $idcommande = $this->request->getPost('idcommande');
    $idarticle = $this->request->getPost('idarticle');
    $dataDetail = $this->commandesDetailModel->getWhere(['vente_id'=>$idcommande,'is_negotiate'=>2])->getResult();
      if(count($idarticle) < count($dataDetail)){
        $upd = $this->model->update(['id'=>$idcommande],['is_negotiate'=>2]);
      }else{
        $upd = $this->model->update(['id'=>$idcommande],['is_negotiate'=>1]);
      }
      if($upd){
        for ($i=0; $i < count($idarticle); $i++) {
          $condition = [
            'vente_id' =>$idcommande,
            'articles_id'=>$idarticle[$i]
          ];
          $data = $this->commandesDetailModel->getWhere($condition)->getRow();
          if($this->commandesDetailModel->update($data->id,['is_negotiate'=>1,'prix_negociation'=>NULL])){
            $status = 200;
            $message = [
              'success' => 'La Négociation a été annulée',
              'errors' => null
            ];
            $data = "";

          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => "Echec annulation negotiation article detail"
            ];
            $data = "";
          }
        }

      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => "Echec annulation negotiation achat"
        ];
        $data = "";
      }


    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTIONS POUR ANNULER LA COMMANDE DONC UN ACHAT
  public function annuler_commande_achat(){
    $pwd = $this->request->getPost('pwd');
    $idcommande = $this->request->getPost('idcommande');
    $iduser = $this->request->getPost('iduser');
    // print_r($idcommande);
    // exit();
    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      //TEST IF COMMANDE STILL HAVE STATUS ATTENTE STATUS


      //SUITES VALIDATIONS
      $nbrAnnule = 1;
      for ($i=0; $i < count($idcommande); $i++) {
        $data = ['status_vente_id'=>4];

        if($this->model->find($idcommande[$i])->status_vente_id->id==1){ // TEST IF ARTICLES
          if(!$updateData = $this->model->update($idcommande[$i],$data)){
            $status = 400;
            $message = [
              'success' => null,
              'errors' => $this->model->erros()
            ];
            $data = "";
          }else {
            //CREATION HISTORIQUE CHANGEMENT STATUS
            $dataStatusHistorique=[
                'vente_id' => $idcommande[$i],
                'status_vente_id' => 4,
                'users_id' => $iduser,
            ];
            if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
              $status = 200;
              $message = [
                'success' => $nbrAnnule++ .' Achat(s) annulé(s) avec succès',
                'errors' => null
              ];
              $data = "";

            }else{
              $status = 400;
              $message = [
                'success' => null,
                'errors' => $this->commandesStatusHistoriqueModel->erros()
              ];
              $data = "";
            }
          }
        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => ["Certaine(s) facture(s) pourraient ne pas être annuler car elles sont probablement déjà été payées ou livrées; veuillez actualiser svp"]
          ];
          $data = "";
        }

      }

    }
    // $this->model->RollbackTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }
  //############LES FONCTIONS DE LA RECHERCHE @@@@@@@@#############

  //FUNCTION POUR ENREGISTRER LES QUANTITES D'ARTICLES RETIREE APRES LIVRAISON

  public function save_article_retirer_commande(){
    $iduser = $this->request->getPost('iduser');
    $vente_detail_id = $this->request->getPost('vente_detail_id');
    $qte = $this->request->getPost('qte');
    $pwd = $this->request->getPost('pwd');
    $this->aretirerModel->beginTrans();

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";

    }else{
    for ($i=0; $i < count($vente_detail_id); $i++) {
      //CHECK IF HISTOR A RETIRER EXISTE DEJA
      $infoDetailVente = $this->commandesDetailModel->find($vente_detail_id[$i]);
      $infoVente = $this->model->find($infoDetailVente->vente_id);

      $qtevendue = $infoDetailVente->qte_vendue;
      $idarticle = $infoDetailVente->articles_id[0]->id;
      $iddepot = $infoVente->depots_id[0]->id;

      if(!$this->aretirerModel->Where('vente_detail_id', $vente_detail_id[$i])->find()){
          //on rajoute la quantite vendue dans stock reel et personnel

          if($this->stockModel->updateQteReelleStockDepot($iddepot, $idarticle, $qtevendue,1)){
            $this->stockPersonnelModel->updateQtePersonnel($iduser, $idarticle, $qtevendue,1);
          }
      }

        $data = ['vente_detail_id'=>$vente_detail_id[$i],'qte_retirer'=>$qte[$i],'users_id'=>$iduser];
        if(!$this->aretirerModel->insert($data)){
          $this->aretirerModel->RollbackTrans();
          $message = [
            'success' =>null,
            'errors' => ["Echec de l'opération; veuillez réesayer"]
          ];
          return $this->respond([
            'status' => 400,
            'message' =>$message,
            'data'=> $data=null
          ]);
        }

        $this->stockModel->updateQteReelleStockDepot($iddepot, $idarticle, $qte[$i],0);
        $this->stockPersonnelModel->updateQtePersonnel($iduser, $idarticle, $qte[$i],0);


        //Update commande to show that was a aretrire operatoon
        // $detailVente = $this->commandesDetailModel->Where('id',$vente_detail_id[$i])->find();
        // $updateCommande =  $this->model->update($detailVente[0]->vente_id,['have_oper_a_retirer' => 1]);
        // print_r($detailVente[0]->vente_id);
        //$this->commandesDetailModel->set('is_livrer',1)->Where('vente_id',$idcommande)->Where('is_faveur',1)->update();
        // die();
      }

      $status = 200;
      $message = [
        'success' =>"Les quantités retirées ont été bien enregistrées avec succès",
        'errors' => null
      ];
      $data = "";
    }
    $this->aretirerModel->commitTrans();
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }

  public function retourne_facture_livre_en_paye(){
    $iduser = $this->request->getPost('iduser');
    $vente_id = $this->request->getPost('vente_id');
    $pwd = $this->request->getPost('pwd');
    $this->model->beginTrans();

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";

    }else{

        $infoVente = $this->model->find($vente_id);
        $iddepot = $infoVente->depots_id[0]->id;
        $infoDetailVente = $this->commandesDetailModel->Where('vente_id',$vente_id)->Where('is_validate_livrer',1)->findAll();
        $array = [];
        if($infoDetailVente and $infoVente->status_vente_id->id==3){
          foreach ($infoDetailVente as $key => $value) {
            $qtevendue = $value->qte_vendue;
            $idarticle = $value->articles_id[0]->id;
            $magaz = $value->livrer_by;

            $this->stockModel->updateQteReelleStockDepot($iddepot, $idarticle, $qtevendue,1);
            $this->stockPersonnelModel->updateQtePersonnel($magaz, $idarticle, $qtevendue,1);
            // $array=[$qtevendue,$idarticle,];
            // array_push($array,[$qtevendue,$idarticle,$magaz]);

            $this->commandesDetailModel->update($value->id, ['is_validate_livrer'=>0,'livrer_by'=>null]);

          }
          //UPDATE VENTE OPERATIONS
          $data = ['status_vente_id'=>2,'retour_en_payer'=>1,'is_livrer_all'=>0];
          $updateData = $this->model->update($vente_id,$data);

          $status = 200;
          $message = [
            'success' => "La facture est passé du status livré à payer avec succès",
            'errors' => null
          ];
          $data = $array;
        }else{
          $status = 400;
          $message = [
            'success' => null,
            'errors' => ["Impossible d'effectuer cette operation sur cette facture, il semble qu'elle est encore en status payé!"]
          ];
          $data = $array;
        }





        // $histo = $this->commandesStatusHistoriqueModel->Where('vente_id',$vente_id)->Where('status_vente_id',3)->find();
        // foreach ($histo as $key => $value) {
        //   // code...
        //   // $this->commandesStatusHistoriqueModel->delete(['id' =>$value->id ]);
        // }


        // $iddepot = $infoVente->depots_id[0]->id;
        //
        // $infoDetailVente = $this->commandesDetailModel->Where('vente_id',$vente_id)->find();
        // foreach ($infoDetailVente as $key => $value) {
        //   $qtevendue = $infoDetailVente->qte_vendue;
        //   $idarticle = $infoDetailVente->articles_id[0]->id;
        //
        //   // $this->stockModel->updateQteReelleStockDepot($iddepot, $idarticle, $qtevendue,1)
        //   // $this->stockPersonnelModel->updateQtePersonnel($iduser, $idarticle, $qtevendue,1)
        //   $array=[$qtevendue,$idarticle,]

        //}

        // $qtevendue = $infoDetailVente->qte_vendue;
        // $idarticle = $infoDetailVente->articles_id[0]->id;


    }
    $this->model->commitTrans();
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function delete_facture(){
    $iduser = $this->request->getPost('iduser');
    $vente_id = $this->request->getPost('vente_id');
    $pwd = $this->request->getPost('pwd');
    $this->commandesStatusHistoriqueModel->beginTrans();

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";

    }else{
      $checkIfThereNoArticleLivredInThisCommand = $this->commandesDetailModel->Where('is_validate_livrer',1)->Where('vente_id',$vente_id)->find();
      if($checkIfThereNoArticleLivredInThisCommand){
        $status = 400;
        $message = [
          'success' => null,
          'errors' => ["Impossible d'annuler cette facture car certain(s) article(s) sont déjà livré(s)"]
        ];
        $data = "";
      }else{
        $infoVente = $this->model->find($vente_id);
        $histo = $this->commandesStatusHistoriqueModel->Where('vente_id',$vente_id)->Where('status_vente_id',3)->find();

        $iddepot = $infoVente->depots_id[0]->id;

        // $qtevendue = $infoDetailVente->qte_vendue;
        // $idarticle = $infoDetailVente->articles_id[0]->id;
        $status = 201;
        $message = [
          'success' => "La facture est passé du status livré à payer avec succès",
          'errors' => null
        ];
        $data = $histo;
      }
    }
    $this->commandesStatusHistoriqueModel->commitTrans();
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }


  //LISTE DE COMMANDE PAR UTILISATEUR FACTURIER LORS DE LA RECHERCHE: DONC LES COMMANDES CREES PAR UN FACTURIER
  public function search_commandes_get_user_facturier($iduser,$statutVente,$dateFilter,$dataToSearch,$type,$isParameterAdvanced,$limit,$offset){
    //$isParameterAdvanced : if 0 donc pas de filtre de date ni de status, si 3 il y a filtre de date et de status, si 1 filtre de date , si 2 filtre de status

    $conditionDate =[];
    $conditionStatus =[];
    if($isParameterAdvanced==3)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    if($isParameterAdvanced==1)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
    }
    if($isParameterAdvanced==2)
    {
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }

    if($type==1){
      $conditionLike = ['numero_commande'=>$dataToSearch];
    }else{
      $conditionLike = ['nom_client'=>$dataToSearch];
    }
    $data = $this->model->Where($conditionDate)->Where('users_id',$iduser)->where($conditionStatus)->like($conditionLike)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->SearchcommandeByTypeByuser($iduser,'users_id',$conditionDate,$conditionLike),
      // 'isparam' => $isParameterAdvanced
    ]);
  }
  //FONCTION COMPLEMENTAIRE DE POUR GET LE NOMBRES DES COMMANDES SELON LE USER OU TYPE DU USE OU TYPE DE COMMANDES EN LA RECHERCHE
  public function SearchcommandeByTypeByuser($iduser,$nomchamps,$conditionDate,$conditionLike){

      $conditionAttente = ['status_vente_id'=>1];
      $conditionPayer = ['status_vente_id'=>2];
      $conditionLivrer = ['status_vente_id'=>3];
      $conditionAnnuler = ['status_vente_id'=>4];
      $conditionSupprimer = ['status_vente_id' => 5];


      return $array = [
        'attente'=>count($this->model->Where($conditionDate)->Where($nomchamps,$iduser)->Where($conditionAttente)->like($conditionLike)->findAll()),
        'payer'=>count($this->model->Where($conditionDate)->Where($nomchamps,$iduser)->Where($conditionPayer)->like($conditionLike)->findAll()),
        'livrer'=>count($this->model->Where($conditionDate)->Where($nomchamps,$iduser)->Where($conditionLivrer)->like($conditionLike)->findAll()),
        'annuler'=>count($this->model->Where($conditionDate)->Where($nomchamps,$iduser)->Where($conditionAnnuler)->like($conditionLike)->findAll()),
        'delete'=>count($this->model->Where($conditionDate)->Where($nomchamps,$iduser)->Where($conditionSupprimer)->like($conditionLike)->findAll()),
      ];

  }
  //LISTE DE COMMANDE PAR UTILISATEUR CAISSIER : DONC LES COMMANDES CREES PAR UN FACTURIER
  public function search_commandes_get_user_caissier($iduser,$statutVente,$dateFilter,$dataToSearch,$type,$isParameterAdvanced,$limit,$offset){
    $conditionDate =[];
    $conditionStatus =[];
    if($isParameterAdvanced==3)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    if($isParameterAdvanced==1)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
    }
    if($isParameterAdvanced==2)
    {
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }

    if($type==1){
      $conditionLike = ['numero_commande'=>$dataToSearch];
    }else{
      $conditionLike = ['nom_client'=>$dataToSearch];
    }
    $data = $this->model->Where($conditionDate)->Where('payer_a',$iduser)->where($conditionStatus)->like($conditionLike)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->SearchcommandeByTypeByuser($iduser,'payer_a',$conditionDate,$conditionLike)
    ]);
  }

  //FONCTION POUR AFFICHER LES COMMANDES AFFECTER A UN DEPOT SPECIFIQUE RECHERCHE
  public function search_commandes_get_by_depot($iddepot,$statutVente,$dateFilter,$dataToSearch,$type,$isParameterAdvanced,$limit,$offset){
    $conditionDate =[];
    $conditionStatus =[];
    if($isParameterAdvanced==3)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    if($isParameterAdvanced==1)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
    }
    if($isParameterAdvanced==2)
    {
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }

    if($type==1){
      $conditionLike = ['numero_commande'=>$dataToSearch];
    }else{
      $conditionLike = ['nom_client'=>$dataToSearch];
    }
    $data = $this->model->Where($conditionDate)->Where('depots_id',$iddepot)->where($conditionStatus)->like($conditionLike)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->SearchcommandeByTypeByuser($iddepot,'depots_id',$conditionDate,$conditionLike)
    ]);
  }

  //FONCTION POUR RECHERCHER LES COMMANDES FAVEURS AFFECTER A UN DEPOT CENTRAL RECHERCHE
  public function search_commandes_faveur_get_by_depot($iddepot,$statutVente,$dateFilter,$dataToSearch,$type,$isParameterAdvanced,$limit,$offset){
    $conditionDate =[];
    $conditionStatus =[];
    $conditionDepotCentralTraiteurFaveur = ['depots_id_faveur' => $iddepot];
    if($isParameterAdvanced==3)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    if($isParameterAdvanced==1)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
    }
    if($isParameterAdvanced==2)
    {
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }

    if($type==1){
      $conditionLike = ['numero_commande'=>$dataToSearch];
    }else{
      $conditionLike = ['nom_client'=>$dataToSearch];
    }
    $data = $this->model->Where($conditionDate)->Where('container_faveur',1)->Where($conditionDepotCentralTraiteurFaveur)->where($conditionStatus)->like($conditionLike)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuserFaveur($iddepot,'depots_id_faveur',$conditionDate,$conditionLike,$conditionDepotCentralTraiteurFaveur)
    ]);
  }


  //FONCTION RECHERECHER ALL COMMANDES ADMINSTRATION
  public function search_commandes_all_get_by_status($statutVente,$dateFilter,$dataToSearch,$type,$isParameterAdvanced,$limit,$offset){
    $conditionDate =[];
    $conditionStatus =[];
    if($isParameterAdvanced==3)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    if($isParameterAdvanced==1)
    {
      $d = Time::today();
      if($dateFilter == "null"){ $dateFilter = $d; }
      $conditionDate =['date_vente'=> $dateFilter];
    }
    if($isParameterAdvanced==2)
    {
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }

    if($type==1){
      $conditionLike = ['numero_commande'=>$dataToSearch];
    }else{
      $conditionLike = ['nom_client'=>$dataToSearch];
    }
    $data = $this->model->Where($conditionDate)->where($conditionStatus)->like($conditionLike)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->SearchcommandeByTypeByuser(null,'logic_article',$conditionDate,$conditionLike),
      'sommesTotalAllCommandes' =>$this->searchSommesMontantTotalParTypeDeVente($conditionStatus,$conditionDate,$conditionLike)
    ]);
  }
  public function searchSommesMontantTotalParTypeDeVente($conditionStatus,$conditionDate,$conditionLike){
    $sommesTotal = 0;
    $allVente = $this->model->Where($conditionStatus)->Where($conditionDate)->like($conditionLike)->findAll();
    foreach ($allVente as $key) {
      $detail = $this->commandesDetailModel->Where('vente_id',$key->id)->findAll();
      $sommes= 0;
      foreach ($detail as $key => $value) {
        $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;
        $sommes +=$montant;
      }
      $sommesTotal+=$sommes;
    }
    return round($sommesTotal,2);
  }
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################

  //FONCTION POUR AFFICHER LA LISTE DE TOUTES LES OPERATIONS SANS EXCEPTIONS ADMIN
  public function commandes_all_get_by_status($statutVente,$dateFilter,$limit,$offset,$isPartiel,$isAretirer){
    $d = Time::today();
    $d = explode(' ',$d);
    $d = $d[0];

    if($dateFilter == "null"){
      $dateFilter = $d;
    }
    $condition =['date_vente'=> $dateFilter];
    $conditionLike =[];
    $conditionStatus =[];
    if($statutVente!=6){
      $conditionStatus = ['status_vente_id'=>$statutVente];
    }
    $conditionPartiel = [];
    if($isPartiel == 1){
      $conditionPartiel = ['is_livrer_all'=>1];
      if($dateFilter == $d){
        $condition =[];
      }
    }
    $data = $this->model->orderBy('id','DESC')->Where($condition)->where($conditionStatus)->Where($conditionPartiel)->findAll($limit,$offset);

    if($isAretirer ==1){

      $conditionDate =['date_vente'=> $dateFilter];
      if($dateFilter == $d){
          $conditionDate =[];
      }

      $dataAnc = $this->model->select("*, g_interne_vente.id, g_interne_vente.created_at")->distinct('')->join('g_interne_vente_detail','g_interne_vente_detail.vente_id=g_interne_vente.id','right')->join('g_interne_a_retirer','g_interne_a_retirer.vente_detail_id=g_interne_vente_detail.id','right')->orderBy('g_interne_vente.id','DESC')->groupBy('g_interne_vente.numero_commande')->Where('g_interne_vente.status_vente_id',$statutVente)->Where($conditionDate)->findAll($limit,$offset);

      $dataCount = $this->model->select("*, g_interne_vente.id,g_interne_vente.created_at")->distinct('')->join('g_interne_vente_detail','g_interne_vente_detail.vente_id=g_interne_vente.id','right')->join('g_interne_a_retirer','g_interne_a_retirer.vente_detail_id=g_interne_vente_detail.id','right')->orderBy('g_interne_vente.id','DESC')->groupBy('g_interne_vente.numero_commande')->Where('g_interne_vente.status_vente_id',$statutVente)->Where($conditionDate)->findAll();


      $data = $dataAnc;

    }

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> $isAretirer ==0 ? $this->model->selectCount('id')->Where($condition)->Where($conditionStatus)->Where($conditionPartiel)->orderBy('id','DESC')->findAll()[0]->id : count($dataCount),
      'nombreVenteType' => $this->commandeByTypeByuser(null,'logic_article',$condition),
      'sommesTotalAllCommandes' =>$this->sommesMontantTotalParTypeDeVente($conditionStatus,$condition,$conditionLike)
    ]);
  }

  //FONCTION LISTE DE COMMANDE EN ATTENTE DE VALIDATION
  public function commandes_get_en_negotiation($statusCommandeNegotiation){
    $data = $this->model->Where('is_negotiate',$statusCommandeNegotiation)->Where('status_vente_id',1)->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteTypeNegotiation' => $this->NbreAchatByTypeNegotiation($statusCommandeNegotiation)
    ]);
  }


// ###########################SUPPLEMENTAIRES###################
// ###########################SUPPLEMENTAIRES###################
// ###########################SUPPLEMENTAIRES###################
// ###########################SUPPLEMENTAIRES###################
  //FONCTIONS COMPLEMENTAIRE REUSABLE
  public function sommesMontantTotalParTypeDeVente($conditionStatus,$condition,$conditionLike){
    $sommesTotal = 0;
    $allVente = $this->model->Where($conditionStatus)->Where($condition)->like($conditionLike)->findAll();
    foreach ($allVente as $key) {
      $detail = $this->commandesDetailModel->Where('vente_id',$key->id)->findAll();
      $sommes= 0;
      foreach ($detail as $key => $value) {
        $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;
        $sommes +=$montant;
      }
      $sommesTotal+=$sommes;
    }
    return round($sommesTotal,2);
  }
  public function NbreAchatByTypeNegotiation($statusCommandeNegotiation){
    return $array =[
      'negotiation_attente'=>count($this->model->orderBy('id','DESC')->Where('status_vente_id',1)->Where('is_negotiate',1)->findAll()),
      'negotiation_valide'=>count($this->model->orderBy('id','DESC')->Where('status_vente_id',1)->Where('is_negotiate',2)->findAll()),
    ];

  }


//HELPER MODEL FUNCTION
  // public function


}
