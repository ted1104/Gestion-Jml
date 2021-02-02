<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ApprovisionnementsEntity;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\StockModel;
use App\Models\ArticlesModel;
use App\Models\PvRestaurationModel;
use App\Models\ClotureStockModel;

use App\Entities\StockEntity;
use App\Entities\PvRestaurationEntity;
use App\Entities\ClotureStockEntity;
use CodeIgniter\I18n\Time;




class Approvisionnement extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ApprovisionnementsModel';
  protected $approvisionnementsDetailModel = null;
  protected $stockModel = null;
  protected $articlesModel = null;
  protected $pvRestaurationModel = null;
  protected $clotureStockModel = null;
  




  public function __construct(){
    helper(['global']);
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    $this->stockModel = new StockModel();
    $this->articlesModel = new ArticlesModel();
    $this->pvRestaurationModel = new PvRestaurationModel();
    $this->clotureStockModel = new ClotureStockModel();
    

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
      $qte_total = $data->qte_total;
      $qte_pv = $data->qte_pv;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'approvisionnement_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte'=>$qte[$i],
          'qte_total'=>$qte_total[$i],
          'qte_pv'=>$qte_pv[$i]
        ];
        if(!$this->approvisionnementsDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsDetailModel->errors()
          ];
          return $this->respond([
            'status' => '400',
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
            'status' => '400',
            'message' =>$message,
            'data'=> $dtStock
          ]);
        }

        //ADD PV TO STOCK PV
        $getSpecificArticlePvStock = $this->articlesModel->find($article[$i]);
        $newPvStock = $getSpecificArticlePvStock->qte_stock_pv + $qte_pv[$i];
        if(!$this->articlesModel->update($article[$i],['qte_stock_pv'=>$newPvStock])){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->articlesModel->errors()
          ];
          return $this->respond([
            'status' => '400',
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
  public function approvisionnement_get_by_depot($idDepot,$limit, $offset){
    $data = $this->model->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function approvisionementPvRestaure(){
    $this->pvRestaurationModel->beginTrans();
    $data = new PvRestaurationEntity($this->request->getPost());
    if(!$insertData = $this->pvRestaurationModel->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->pvRestaurationModel->errors()
      ];
      $data = null;
    }else{
      $artInfo = $this->articlesModel->find($data->articles_id);
      $newQte = $artInfo->qte_stock_pv - $data->qte_restaure;
      if(!$this->articlesModel->update($data->articles_id, ['qte_stock_pv'=>$newQte])){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->articlesModel->errors()
        ];
        $data = null;
      }else{
        //UPDATE STOCK IN STOCK
        $condition =[
          'depot_id'=>$data->depots_id_dest[0]->id,
          'articles_id'=>$data->articles_id
        ];

        //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqte = $this->stockModel->getWhere($condition)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $Qte = $initqte->qte_stock + $data->qte_restaure;//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuel = $initqte->qte_stock_virtuel + $data->qte_restaure;
        if(!$this->stockModel->update($initqte->id,['qte_stock'=>$Qte,'qte_stock_virtuel'=>$QteVirtuel])){
          $this->pvRestaurationModel->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsDetailModel->errors()
          ];
          return $this->respond([
            'status' => '400',
            'message' =>$message,
            'data'=>""
          ]);
        }else{
          $status = 200;
          $message = [
            'success' => 'Le dépôt a été bien approvisionné par le(s) PV restauré(s)',
            'errors' => null
          ];
          $data = null;
        }
      }
    }
    $this->pvRestaurationModel->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }

  public function clotureJournalierStock(){
    $d = Time::tomorrow();
    $initStock = $this->stockModel->findAll();
    if(!$this->clotureStockModel->Where('date_cloture',$d)->find()){
      foreach ($initStock as $key => $value) {
        $data = [
          'articles_id'=>$value->articles_id[0]->id,
          'depot_id' =>$value->depot_id,
          'qte_stock' =>$value->qte_stock,
          'qte_stock_virtuel' =>$value->qte_stock_virtuel,
          'date_cloture' =>$d
        ];

        $insertData = $this->clotureStockModel->insert($data);
      }
      echo 'cloture avec success';
    }else{
      echo 'Deja encore';
    }
  }
}
