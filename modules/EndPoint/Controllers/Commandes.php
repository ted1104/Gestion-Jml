<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;

use App\Entities\CommandesEntity;
use App\Models\CommandesDetailModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\UsersAuthModel;
use App\Models\EncaissementModel;
use App\Models\CaisseModel;
use App\Models\StockModel;



class Commandes extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\CommandesModel';
  protected $commandesStatusHistoriqueModel = null;
  protected $usersAuthModel = null;
  protected $encaissementModel = null;
  protected $caisseModel = null;
  protected $commandesDetailModel = null;
  protected $stockModel = null;

  public function __construct(){
    helper(['global']);
    $this->commandesDetailModel = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->usersAuthModel = new UsersAuthModel();
    $this->encaissementModel = new EncaissementModel();
    $this->caisseModel = new CaisseModel();
    $this->stockModel = new StockModel();
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
      //CREATE HISTORIQUE ARTICLE VENDU
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte_vendue = $data->qte_vendue;
      $prix_unitaire = $data->prix_unitaire;
      $type_prix = $data->type_prix;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'vente_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte_vendue'=>$qte_vendue[$i],
          'prix_unitaire' =>$prix_unitaire[$i],
          'type_prix' =>$type_prix[$i],
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
        'success' => 'Enregistrement de la commande avec succès',
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
    $data = $this->model->orderBy('id','DESC')->first();
    $data = $data->id + 1;
    if($data < 10){
      $data = 'FACT-0'.$data;
    }else{
        $data = 'FACT-'.$data;
    }

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  //LISTE DE COMMANDE PAR UTILISATEUR FACTURIER : DONC LES COMMANDES CREES PAR UN FACTURIER
  public function commandes_get_user_facturier($iduser,$statutVente){
    $data = $this->model->orderBy('id','DESC')->Where('users_id',$iduser)->where('status_vente_id',$statutVente)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuser($iduser,'users_id')
    ]);
  }
  //FONCTION COMPLEMENTAIRE DE commandes_get_user_facturier
  public function commandeByTypeByuser($iduser,$nomchamps){
    return $array =[
      'attente'=>count($this->model->orderBy('id','DESC')->Where($nomchamps,$iduser)->Where('status_vente_id',1)->findAll()),
      'payer'=>count($this->model->orderBy('id','DESC')->Where($nomchamps,$iduser)->Where('status_vente_id',2)->findAll()),
      'livrer'=>count($this->model->orderBy('id','DESC')->Where($nomchamps,$iduser)->Where('status_vente_id',3)->findAll()),
      'annuler'=>count($this->model->orderBy('id','DESC')->Where($nomchamps,$iduser)->Where('status_vente_id',4)->findAll()),
    ];

  }

  //LISTE DE COMMANDE PAR UTILISATEUR CAISSIER : DONC LES COMMANDES CREES PAR UN FACTURIER
  public function commandes_get_user_caissier($iduser,$statutVente){
    $data = $this->model->orderBy('id','DESC')->Where('payer_a',$iduser)->where('status_vente_id',$statutVente)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuser($iduser,'payer_a')
    ]);
  }

  //FONCTION VALIDATION OPERATION PAR CAISSIER DONC VALIDATION DU PAYEMENT
  public function validation_operation_commande_caissier($pwd,$idcommande,$iduser,$somme){
    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      //SUITES VALIDATIONS
      $data = ['status_vente_id'=>2];
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
    }
    // $this->model->RollbackTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }

  //FONCTION POUR AFFICHER LES COMMANDES AFFECTER A UN DEPOT SPECIFIQUE
  public function commandes_get_by_depot($iddepot,$statutVente){
    $data = $this->model->orderBy('id','DESC')->Where('depots_id',$iddepot)->where('status_vente_id',$statutVente)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuser($iddepot,'depots_id')
    ]);
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
      if(!$this->model->checkingIfOneArticleHasNotEnoughtQuanity($iddepot,$idcommande)){
        //SUITES VALIDATIONS
        $data = ['status_vente_id'=>3];
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
          if($this->commandesStatusHistoriqueModel->insert($dataStatusHistorique)){
            //DECOMPTE DU STOCK DEOPOTS
            $allArt = $this->commandesDetailModel->Where('vente_id',$idcommande)->findAll();
            foreach ($allArt as $key => $value) {
              $stokdepot = $this->stockModel->getWhere(['depot_id'=>$iddepot,'articles_id'=>$value->articles_id[0]->id])->getRow();
              $stokinit = $stokdepot->qte_stock;
              $qte_a_retrancher = $value->qte_vendue;
              $nvlleqte = $stokinit-$qte_a_retrancher;
              $this->stockModel->update($stokdepot->id,['qte_stock'=>$nvlleqte]);
            }
            $status = 400;
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
    }
    // $this->model->RollbackTrans();
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

  //FONCTION POUR VALIDER UNE NEGOTIATION
  public function commande_validate_negotiation(){
    $idcommande = $this->request->getPost('idcommande');
    $idarticle = $this->request->getPost('idarticle');
    $montantNegocier = $this->request->getPost('montant');
    for ($i=0; $i < count($idarticle); $i++) {
      if($this->model->update(['id'=>$idcommande],['is_negotiate'=>2])){
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

  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  //################ FONCTION ADMINISTRTION #####################
  public function commandes_all_get_by_status($statutVente){
    $data = $this->model->orderBy('id','DESC')->where('status_vente_id',$statutVente)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'nombreVenteType' => $this->commandeByTypeByuser(null,'logic_article'),
      'sommesTotalAllCommandes' =>$this->sommesMontantTotalParTypeDeVente($statutVente)
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
  public function sommesMontantTotalParTypeDeVente($idStatusVente){
    $sommesTotal = 0;
    $allVente = $this->model->Where('status_vente_id',$idStatusVente)->findAll();
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
}
