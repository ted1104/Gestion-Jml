<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ApprovisionnementsInterDepotEntity;
use App\Models\ApprovisionnementsInterDepotDetailModel;
use App\Models\StockModel;
use App\Entities\StockEntity;



class ApprovisionnementInterDepot extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ApprovisionnementsInterDepotModel';
  protected $approvisionnementsInterDepotDetailModel = null;
  protected $stockModel = null;




  public function __construct(){
    helper(['global']);
    $this->approvisionnementsInterDepotDetailModel = new ApprovisionnementsInterDepotDetailModel();
    $this->stockModel = new StockModel();

  }
  public function approvisionnementInterDepot_get($limit, $offset){
    $data = $this->model->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->orderBy('id','DESC')->findAll())
    ]);
  }
  public function approvisionnementInterDepot_create(){
    $this->model->beginTrans();
    $data = new ApprovisionnementsInterDepotEntity($this->request->getPost());
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
        if(!$this->approvisionnementsInterDepotDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsInterDepotDetailModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=>""
          ]);
        }
        //UPDATE STOCK IN STOCK DEPOT DESTINATION
        $conditionDest =[
          'depot_id'=>$this->request->getPost('depots_id_dest'),
          'articles_id'=>$article[$i]
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqteDest = $this->stockModel->getWhere($conditionDest)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $QteDest = $initqteDest->qte_stock + $qte[$i];//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuelDest = $initqteDest->qte_stock_virtuel + $qte[$i];

        //UPDATE STOCK IN STOCK DEPOT DESTINATION
        $conditionSource =[
          'depot_id'=>$this->request->getPost('depots_id_source'),
          'articles_id'=>$article[$i]
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $QteSource = $initqteSource->qte_stock - $qte[$i];//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuelSource = $initqteSource->qte_stock_virtuel - $qte[$i];
        // return $this->respond([$initqte]);

        $updStockDest = $this->stockModel->update($initqteDest->id,['qte_stock'=>$QteDest,'qte_stock_virtuel'=>$QteVirtuelDest]);

        $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock'=>$QteSource,'qte_stock_virtuel'=>$QteVirtuelSource]);

        if(!$updStockDest and !$updStockSource){
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
      $data = null;
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function approvisionnementInterDepot_get_by_depot($idDepot,$limit, $offset){
    $data = $this->model->Where('depots_id_source',$idDepot)->orWhere('depots_id_dest', $idDepot)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where('depots_id_source',$idDepot)->orWhere('depots_id_dest', $idDepot)->orderBy('id','DESC')->findAll())
    ]);
  }
}
