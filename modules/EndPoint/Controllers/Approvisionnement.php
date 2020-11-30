<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ApprovisionnementsEntity;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\StockModel;
use App\Entities\StockEntity;



class Approvisionnement extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ApprovisionnementsModel';
  protected $approvisionnementsDetailModel = null;
  protected $stockModel = null;




  public function __construct(){
    helper(['global']);
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    $this->stockModel = new StockModel();

  }
  public function approvisionnement_get($limit, $offset){
    $data = $this->model->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->orderBy('id','DESC')->findAll())
    ]);
  }
  public function approvisionnement_create(){
    $this->model->beginTrans();
    $data = new ApprovisionnementsEntity($this->request->getPost());
    if(!$insertData = $this->model->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      //CREATE COMMANDE  DETAIL AVEC ARTICLE STOCK
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte = $data->qte;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'approvisionnement_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte'=>$qte[$i],
        ];
        if(!$this->approvisionnementsDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsDetailModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=>""
          ]);
        }
        //UPDATE STOCK IN STOCK
        $condition =[
          'depot_id'=>$this->request->getPost('depots_id'),
          'articles_id'=>$article[$i]
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqte = $this->stockModel->getWhere($condition)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $Qte = $initqte->qte_stock + $qte[$i];//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuel = $initqte->qte_stock_virtuel + $qte[$i];

        // return $this->respond([$initqte]);

        if(!$this->stockModel->update($initqte->id,['qte_stock'=>$Qte,'qte_stock_virtuel'=>$QteVirtuel])){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->stockModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=> $dtStock
          ]);
        }
      }

      $status = 200;
      $message = [
        'success' => 'Le dépôt a été bien approvisionné',
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
  public function approvisionnement_get_by_depot($idDepot,$limit, $offset){
    $data = $this->model->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll())
    ]);
  }
}
