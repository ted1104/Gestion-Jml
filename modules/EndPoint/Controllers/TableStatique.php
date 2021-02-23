<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StDepotModel;
use App\Models\StEtatCritiqueModel;
use App\Models\ArticlesModel;
use App\Models\StockModel;
use App\Models\StProfileModel;
use App\Models\ClotureStockModel;
use App\Models\ClotureCaisseModel;
use App\Models\UsersModel;
use App\Models\UsersAuthModel;
use CodeIgniter\I18n\Time;

class TableStatique extends ResourceController {
  protected $format = 'json';
  protected $depotsModel = null;
  protected $articleModel = null;
  protected $stockModel = null;
  protected static $stetatcritique = null;
  protected static $stProfileModel = null;
  protected $clotureStockModel = null;
  protected $clotureCaisseModel = null;
  protected $userModel = null;
  protected $usersAuthModel = null;

  public function __construct(){
    helper(['global']);
    $this->depotsModel = new StDepotModel();
    $this->articleModel = new ArticlesModel();
    $this->stockModel = new StockModel();
    self::$stetatcritique = new StEtatCritiqueModel();
    self::$stProfileModel = new StProfileModel();
    $this->clotureStockModel = new ClotureStockModel();
    $this->clotureCaisseModel =  new ClotureCaisseModel();
    $this->userModel = new UsersModel();
    $this->usersAuthModel = new UsersAuthModel();
  }

  public function depot_get(){
    $data = $this->depotsModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function depot_create(){
    $data = $this->request->getPost();
      if($this->depotsModel->checkingIfAnotherDepotCentralExit($data['is_central'])){
            $insertData = $this->depotsModel->insert($data);
             if(!$insertData){
               $status = 400;
               $message = [
                 'success' =>null,
                 'errors'=>$this->depotsModel->errors()
               ];
               $data = null;
             }else{
               $article = $this->articleModel->findAll();
               foreach ($article as $key => $value) {
                 $datStock = [
                   'articles_id'=>$value->id,
                   'depot_id'=>$insertData,
                   'qte_stock'=>0
                 ];
                 if(!$this->stockModel->insert($datStock)){
                   $this->depotsModel->RollbackTrans();
                 }
               }
               $status = 200;
               $message = [
                 'success' => 'Enregistrement reussi',
                 'errors' => null
               ];
               $data = $insertData;
             }
      }else{
         $status = 400;
         $message = [
           'success' =>null,
           'errors'=>['un autre dépôt central existe déjà']
         ];
         $data = null;
    }
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function depot_update($id){
    $data = $this->request->getJSON();
    $updateData = $this->depotsModel->update($id,$data);
    if(!$updateData){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>'Le nom dépôt existe déjà'
      ];
    }else{
      $status = 200;
      $message = [
        'success' => 'Mise à jour reussie',
        'errors' => null
      ];
      $data = $updateData;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function getStockDepot(){
    $data = $this->depotsModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'critique' => self::$stetatcritique->findAll()
    ]);
  }
  public function getStockDepotByDepot($idDepot){
    $data = $this->depotsModel->find($idDepot);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'critique' => self::$stetatcritique->findAll()
    ]);
  }
  public function getEtatCritique(){
    $data = self::$stetatcritique->find();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function updateEtatCritique(){
    $data = $this->request->getJSON();
    if($data->montant_min < $data->montant_max){
      if(!self::$stetatcritique->update(1, $data)){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>self::$stetatcritique->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' =>'Mise à jour avec succès de la configuration',
          'errors'=>null
        ];
        $data = null;
      }
    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>['Le nombre maximum doit être superieur au nombre minimum']
      ];
      $data = null;
    }

    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data,
    ]);
  }
  public function getProfile(){
    $data = self::$stProfileModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function detectEtatDesParametresSysteme(){
    //STOCK CLOTURE
    $d = Time::tomorrow();
    $cloture_stock = $this->clotureStockModel->Where('date_cloture',$d)->find();

    //CAISEE CLOTURE
    $dy = Time::today();
    $cloture_caisse = $this->clotureCaisseModel->Where('date_cloture',$dy)->find();

    //ETAT COMPTE
    $allUserToBlockAccount = $this->userModel->Where('roles_id !=',1)->findAll();
    $IsBloqued = true;
    foreach ($allUserToBlockAccount as $key => $value) {
      $in = $this->usersAuthModel->Where('users_id',$value->id)->find();
      if($in[0]->status_users_id == 1){
        $IsBloqued = false;
      }
    }


    $data = [
      "cloture_stock" => $cloture_stock ? true : false,
      "cloture_caisse" => $cloture_caisse ? true : false,
      "etat_compte" => $IsBloqued ? true:false,
    ];

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }

}
