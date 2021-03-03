<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StockModel;
use App\Entities\StockEntity;
use App\Entities\TransfertStockEntity;
use App\Models\StockPersonnelModel;
use CodeIgniter\I18n\Time;

use App\Models\TransfertStockDetailModel;
use App\Models\UsersAuthModel;




class TransfertStockDepot extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\TransfertStockModel';
  protected $stockModel = null;
  protected $stockPersonnelModel = null;
  protected $transfertStockDetailModel = null;
  protected $usersAuthModel = null;


  public function __construct(){
    helper(['global']);
    $this->stockModel = new StockModel();
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->transfertStockDetailModel = new TransfertStockDetailModel();
    $this->usersAuthModel = new UsersAuthModel();

  }


  public function transfert_create(){
    $this->model->beginTrans();
    $data = new TransfertStockEntity($this->request->getPost());
    // print_r($data->users_id_source);
    // die();
    if(!$insertData = $this->model->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      //CREATE LIGNE STOCK PERSONNEL IF NOT EXIST
      // $this->StockPersonnelModel->insertArticleInStockPersonnelIfNotExit($data->users_id->id);
      //CREATE COMMANDE  DETAIL AVEC ARTICLE STOCK
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte = $data->qte;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'transfert_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte'=>$qte[$i],
        ];
        if(!$this->transfertStockDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->transfertStockDetailModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=>""
          ]);
        }

        $this->stockPersonnelModel->updateQtePersonnel($data->users_id_source[0]->id, $article[$i], $qte[$i],2);
      }

      $status = 200;
      $message = [
        'success' => 'Transfert de stock reussi mais reste en attente de validation',
        'errors' => null
      ];
      $data = null;
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function transfert_get_by_depot($idMag,$limit, $offset,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_transfert'=> $dateFilter];
    $conditionSource = [
      'users_id_source'=>$idMag,
      'date_transfert'=> $dateFilter
    ];
    $conditionDest= [
      'users_id_dest'=>$idMag,
      'date_transfert'=> $dateFilter
    ];
    $where = "(users_id_dest='".$idMag."' or users_id_source='".$idMag."') and date_transfert='".$dateFilter."'";


    $data = $this->model->Where($where)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where($conditionSource)->Where($conditionDest)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function validateTransfert($pwd,$idTransfert,$iduser){
    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      $infoTransfert = $this->model->find($idTransfert);
      $user_source = $infoTransfert->users_id_source[0]->id;
      $user_dest = $infoTransfert->users_id_dest[0]->id;
      // $userSource = $infoTransfert->users_id->id;

      $data = ['status_operation'=>2];
      if(!$updateData = $this->model->update($idTransfert,$data)){
        $status = 400;
        $message = [
          'success' => null,
          'errors' => $this->model->erros()
        ];
        $data = "";
      }else{
        $allArt = $this->transfertStockDetailModel->Where('transfert_id',$idTransfert)->Where('is_validate',0)->findAll();
        foreach ($allArt as $key => $value) {
          //UPDATE STOCK PERSONNEL
          $upd = $this->stockPersonnelModel->updateQtePersonnel($iduser,$value->articles_id[0]->id,$value->qte); //STOCK PERSONNEL DESTINATION
          $updat = $this->transfertStockDetailModel->update($value->id, ['is_validate'=>1]);
        }

        if(!$upd and !$updat){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->stockPersonnelModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            // 'data'=> $dtStock
          ]);
        }

        $status = 200;
        $message = [
          'success' => 'Le transfert a été validé avec succès',
          'errors' => null
        ];
        $data = null;
      }
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
}
