<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CaisseModel;
use App\Models\DecaissementModel;
use App\Entities\DecaissementEntity;
use App\Entities\DecaissementExterneEntity;
use App\Models\UsersAuthModel;
use App\Models\DecaissementExterneModel;




class OperationCaisseEncaissement extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\EncaissementModel';
  protected $caisseModel = null;
  protected $decaissementModel  = null;
  protected $usersAuthModel = null;
  protected $decaissementExterneModel = null;



  public function __construct(){
    helper(['global']);
    $this->caisseModel = new CaisseModel();
    $this->decaissementModel = new DecaissementModel();
    $this->decaissementExterneModel = new DecaissementExterneModel();
    $this->usersAuthModel = new UsersAuthModel();
  }
  //MONTANT SOLDE DU CAISSIER
  public function getMontantCaisse($idCaissier){
    $data = $this->caisseModel->Where('users_id',$idCaissier)->find();
    $montant = 0;
    if($data){
      $montant = $data[0]->montant;
    }
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $montant,
    ]);
  }

  //LISTE DE TOUTES LES OPERATIONS DE DECAISSEMENT EN ATTENTE
  public function getDecaissementCaissierPrincipal($idCaissierMain,$idStatus){
    $data = $this->decaissementModel->Where('users_id_dest',$idCaissierMain)->Where('status_operation',$idStatus)->orderBy('id','DESC')->findAll();
    if($idStatus !==0 && $idStatus !==1 ):
        $data = $this->decaissementModel->Where('users_id_dest',$idCaissierMain)->orderBy('id','DESC')->findAll();
    endif;
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }

  //AJOUTER UNE DEMANDE DE DECAISSEMENT
  public function createDecaissement(){
    $data = new DecaissementEntity($this->request->getPost());
    if(!$this->decaissementModel->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->decaissementModel->errors()
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' => 'Demande de décaissement envoyée et reste en attente',
        'errors' => null
      ];
      $data = 'null';
    }

    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);
  }

  //LISTE DE TOUTES OPERATIONS DE CAISSEMENT CAISSIER SECONDAIRE
  public function getDecaissementParCaissier($idCaissier){
    $data = $this->decaissementModel->Where('users_id_from',$idCaissier)->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }

  //VALIDATION DECAISSEMENT PAR LE CAISSIER PRINCIPAL
  public function validateDecaissement($idDecaissement,$iduser,$pwd){
    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      $data = $this->decaissementModel->find($idDecaissement);
      if($data && $data->status_operation ==0){
        $idUserFrom = $data->users_id_from->id;
        $idUserDest = $data->users_id_dest->id;
        $montant = $data->montant;

        //Si caissier principal existe, update son montant si non on cree sa caisse
        $userExistCaisse = $this->caisseModel->Where('users_id',$idUserDest)->findAll();
        if($userExistCaisse){
          $nvo = $userExistCaisse[0]->montant + $montant;
          $this->caisseModel->update($userExistCaisse[0]->id, ['montant'=>$nvo]);
        }else{
          $dataCaisse = [
            'users_id'=>$idUserDest,
            'montant' => $montant
          ];
          $insertData = $this->caisseModel->insert($dataCaisse);
        }
        //Caissier Secondaire
        $userExistCaisse = $this->caisseModel->Where('users_id',$idUserFrom)->findAll();
        $nvo = $userExistCaisse[0]->montant - $montant;
        $this->caisseModel->update($userExistCaisse[0]->id, ['montant'=>$nvo]);

        //UPDATE OPERATION DECAIISSEMENT
        if($this->decaissementModel->update($idDecaissement,['status_operation'=>1])){
          $status = 200;
          $message = [
            'success' => 'Decaissement effectué avec succès',
            'errors' => null
          ];
        }else{
          $status = 200;
          $message = [
            'success' => null,
            'errors' => ["Echec effectué avec succès"]
          ];
        }
        $data = "";
      }else{
        $status = 400;
        $message = [
          'success' => null,
          'errors' => ["Cette Opération de décaissement n'existe pas ou soit elle est déja validée"]
        ];
        $data = "";
      }
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data,
    ]);

  }

  //LISTE DE DECAIISEMENT EXTERNE EFFECTUE PAR LE CAISSIER PRINCIPAL
  public function getDecaissementExterne($idCaissier){
    $data = $this->decaissementExterneModel->Where('users_id_from',$idCaissier)->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }

  //CREER UN DECAISSEMENT EXTERNTE
  public function createDecaissementExterne(){
    $data = $this->request->getPost();
    $userExistCaisse = $this->caisseModel->Where('users_id',$data['users_id_from'])->findAll();
    $montant = $data['montant'];
    if($data['montant']=="" && !$userExistCaisse){
      $montant = 0;
    }

    if($userExistCaisse[0]->montant >= $montant){
      if(!$this->decaissementExterneModel->insert($data)){

        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->decaissementExterneModel->errors()
        ];
        $data = null;
      }else{
        //Caissier Principal
        $nvo = $userExistCaisse[0]->montant - $montant;
        $this->caisseModel->update($userExistCaisse[0]->id, ['montant'=>$nvo]);
        $status = 200;
        $message = [
          'success' => 'Décaissement reussi',
          'errors' => null
        ];
        $data = 'null';
      }
    }else{
      $status = 200;
      $message = [
        'success' => null,
        'errors' => ["Vous n'avez pas ce montant dans votre caisse"]
      ];
      $data = 'null';
    }

    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }



}
