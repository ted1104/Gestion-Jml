<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StockModel;
use App\Entities\StockEntity;
use App\Entities\TransfertStockEntity;
use App\Models\StockPersonnelModel;
use CodeIgniter\I18n\Time;

use App\Models\TransfertStockDetailModel;




class TransfertStockDepot extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\TransfertStockModel';
  protected $stockModel = null;
  protected $stockPersonnelModel = null;
  protected $transfertStockDetailModel = null;


  public function __construct(){
    helper(['global']);
    $this->stockModel = new StockModel();
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->transfertStockDetailModel = new TransfertStockDetailModel();

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
}
