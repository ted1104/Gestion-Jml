<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StDepotModel;
use App\Models\ArticlesModel;
use App\Models\StockModel;


class TableStatique extends ResourceController {
  protected $format = 'json';
  protected $depotsModel = null;
  protected $articleModel = null;
  protected $stockModel = null;

  public function __construct(){
    helper(['global']);
    $this->depotsModel = new StDepotModel();
    $this->articleModel = new ArticlesModel();
    $this->stockModel = new StockModel();
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
    $data = $this->depotsModel->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
}
