<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\CaisseModel;
use App\Models\DecaissementModel;
use App\Entities\DecaissementEntity;
use App\Entities\DecaissementExterneEntity;
use App\Models\UsersAuthModel;
use App\Models\DecaissementExterneModel;
use App\Models\EncaissementExterneModel;
use App\Entities\EncaissementExterneEntity;
use CodeIgniter\I18n\Time;
use App\Models\ClotureCaisseModel;
use App\Models\LogSystemModel;






class OperationCaisseEncaissement extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\EncaissementModel';
  protected $caisseModel = null;
  protected $decaissementModel  = null;
  protected $usersAuthModel = null;
  protected $decaissementExterneModel = null;
  protected $encaissementExterneModel = null;
  protected $clotureCaisseModel = null;
  protected $logSystemModel = null;





  public function __construct(){
    helper(['global']);
    $this->caisseModel = new CaisseModel();
    $this->decaissementModel = new DecaissementModel();
    $this->decaissementExterneModel = new DecaissementExterneModel();
    $this->usersAuthModel = new UsersAuthModel();
    $this->encaissementExterneModel = new EncaissementExterneModel();
    $this->clotureCaisseModel =  new ClotureCaisseModel();
    $this->logSystemModel = new LogSystemModel();

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

  //LISTE DE TOUTES LES OPERATIONS DE DECAISSEMENT EN ATTENTE et VALIDEE
  public function getDecaissementCaissierPrincipal($idCaissierMain,$idStatus,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_decaissement'=> $dateFilter];

    $conditionUserDest = [];
    if($idCaissierMain != 0){
      $conditionUserDest = ['users_id_dest'=>$idCaissierMain];
    }
    $data = $this->decaissementModel->Where($conditionUserDest)->Where($conditionDate)->Where('status_operation',$idStatus)->orderBy('id','DESC')->findAll();
    if($idStatus !==0 && $idStatus !==1 ):
        $data = $this->decaissementModel->Where($conditionUserDest)->Where($conditionDate)->orderBy('id','DESC')->findAll();
    endif;
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'condition'=>$conditionDate
    ]);
  }

  //AJOUTER UNE DEMANDE DE DECAISSEMENT
  public function createDecaissement(){
    $data = new DecaissementEntity($this->request->getPost());
    $userExistCaisse = $this->caisseModel->Where('users_id',$data->users_id_from->id)->find();
    $montant = $data->montant;
    if($data->montant=="" && !$userExistCaisse){
      $montant = 0;
    }
    if($userExistCaisse[0]->montant >= $montant){
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
  public function getDecaissementExterne($idCaissier,$typeDestination,$dateFilter,$dateFiltreEnd,$isInterval,$limit, $offset){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_decaissement'=> $dateFilter];


    $conditionUserFrom = [];
    $conditionDestination = [];
    if($idCaissier != 0){
      $conditionUserFrom = ['users_id_from'=>$idCaissier];
    }
    if($typeDestination > 0){
      $conditionDestination = ['destination' =>$typeDestination];
    }
    $data = $this->decaissementExterneModel->Where($conditionUserFrom)->Where($conditionDate)->Where($conditionDestination)->orderBy('id','DESC')->findAll($limit, $offset);
    //FOR PAGINATION
    $dataAllCount = $this->decaissementExterneModel->Where($conditionUserFrom)->Where($conditionDate)->Where($conditionDestination)->orderBy('id','DESC')->findAll();

    //MONTANT TOTAL DECAISSE
    $montantTotal = $this->sommesMontantDecaissementExterne($conditionUserFrom,$conditionDate,$conditionDestination);
    if($isInterval ==1){
      $conditionIntevalDate = ['date_decaissement >='=>$dateFilter,'date_decaissement <='=>$dateFiltreEnd];

      $data = $this->decaissementExterneModel->Where($conditionUserFrom)->Where($conditionIntevalDate)->Where($conditionDestination)->orderBy('id','DESC')->findAll($limit, $offset);
      $dataAllCount =  $this->decaissementExterneModel->Where($conditionUserFrom)->Where($conditionIntevalDate)->Where($conditionDestination)->orderBy('id','DESC')->findAll();
      // echo 'in interval'. $dateFiltreEnd;
      $montantTotal = $this->sommesMontantDecaissementExterne($conditionUserFrom,$conditionIntevalDate,$conditionDestination);
    }
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all' => count($dataAllCount),
      'montantTotalDecaissement' => $montantTotal
      // 'conti' => $conditionUserFrom
    ]);
  }

  //CREER UN DECAISSEMENT EXTERNTE
  public function createDecaissementExterne(){
    $data = new DecaissementExterneEntity($this->request->getPost());
    $userExistCaisse = $this->caisseModel->Where('users_id',$data->users_id_from->id)->find();
    $montant = $data->montant;
    if($data->montant=="" && !$userExistCaisse){
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


  ###########OPERATIONS ENCAISSEMENT EXTERNE ####################
  //GET ALL ENCAISSEMENT EXTERNE
//  public function getEncaissementExterne(){
  //   $data = $this->encaissementExterneModel->orderBy('id','DESC')->findAll();
  //   return $this->respond([
  //     'status' => 200,
  //     'message' => 'success',
  //     'data' => $data,
  //   ]);
  // }
  public function createEncaissementExterne(){
    $data = new EncaissementExterneEntity($this->request->getPost());
    $this->encaissementExterneModel->beginTrans();
    if(!$this->encaissementExterneModel->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->encaissementExterneModel->errors()
      ];
      $data = null;
    }else{
      //Si caissier principal existe, update son montant si non on cree sa caisse
      $userExistCaisse = $this->caisseModel->Where('users_id',$data->users_id->id)->findAll();
      if($userExistCaisse){
        $nvo = $userExistCaisse[0]->montant + $data->montant_encaissement;
        $this->caisseModel->update($userExistCaisse[0]->id, ['montant'=>$nvo]);
      }else{
        $dataCaisse = [
          'users_id'=>$data->users_id->id,
          'montant' => $data->montant_encaissement
        ];
        $insertData = $this->caisseModel->insert($dataCaisse);
      }

      $status = 200;
      $message = [
        'success' => 'Encaissemennt effectué avec succès',
        'errors' => null
      ];
      $data = null;
    }

    $this->encaissementExterneModel->commitTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data,
    ]);
  }

  public function getEncaissementExterne($idCaissierMain,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_encaissement'=> $dateFilter];

    $conditionUserSource = [];
    if($idCaissierMain != 0){
      $conditionUserSource = ['users_id'=>$idCaissierMain];
    }
    $data = $this->encaissementExterneModel->select("id,users_id,date_encaissement,motif,created_at,montant_encaissement")->Where($conditionUserSource)->Where($conditionDate)->orderBy('id','DESC')->findAll();

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'sommeEncaissement' => $this->sommesMontantEncaissement($conditionUserSource,$conditionDate)
    ]);
  }

  public function sommesMontantEncaissement($conditionUserSource,$conditionDate){
    $SommeEncaissement = $this->encaissementExterneModel->selectSum('montant_encaissement')->Where($conditionUserSource)->Where($conditionDate)->find();
    return round($SommeEncaissement[0]->montant_encaissement,2);

  }
  public function sommesMontantDecaissementExterne($conditionUserFrom,$conditionDate,$conditionDestination){
    $SommeDecaissement = $this->decaissementExterneModel->selectSum('montant')->Where($conditionUserFrom)->Where($conditionDate)->Where($conditionDestination)->find();
    return round($SommeDecaissement[0]->montant,2);

  }
  // #########CLOTURE OPERATION AUTOMATIQUE
  public function clotureJournalierCaisse($iduser =null){
    $d = Time::today();
    $initCaisse = $this->caisseModel->findAll();
    $this->caisseModel->beginTrans();

    if(!$this->clotureCaisseModel->Where('date_cloture',$d)->find()){
      foreach ($initCaisse as $key => $value) {
        $data = [
          'montant'=>$value->montant,
          'users_id' =>$value->users_id,
          'date_cloture' =>$d
        ];
        $insertData = $this->clotureCaisseModel->insert($data);
      }
      if(!$this->logSystemModel->addLogSys($iduser, 4)){
        $this->caisseModel->RollbackTrans();
      }
      $message = [
        'success' => "La cloture journalière de la caisse a été effectuée avec succès",
        'errors' => null
      ];
    }else{
      $message = [
        'success' => null,
        'errors' => ["Merci de reessayer demain car la cloture journalière de la caisse est déjà faite"]
      ];
    }
    $this->caisseModel->commitTrans();
    return $this->respond([
      'status' => 200,
      'message' =>$message,
      // 'data'=> $data
    ]);
  }
}
