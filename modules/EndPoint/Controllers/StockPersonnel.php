<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StockPersonnelModel;
use App\Models\TransfertStockDetailModel;
use App\Models\UsersModel;

use App\Entities\ApprovisionnementsEntity;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\StockModel;
use App\Models\ArticlesModel;
use App\Models\PvRestaurationModel;
use App\Models\ClotureStockModel;

use App\Entities\StockEntity;
use App\Entities\PvRestaurationEntity;
use App\Entities\ClotureStockEntity;
use App\Entities\TransfertStockEntity;
use CodeIgniter\I18n\Time;




class StockPersonnel extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\StockPersonnelModel';
  protected $stockPersonnelModel = null;
  protected $transfertStockDetailModel = null;
  protected $userModel = null;



  public function __construct(){
    helper(['global']);
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->transfertStockDetailModel = new TransfertStockDetailModel();
    $this->userModel = new UsersModel();

  }
  public function stock_personnel_get(){
    $Magazinier = $this->userModel->Where('roles_id',5)->findAll();
    $array = array();
    foreach ($Magazinier as $key => $value) {
      $ar =[
        'id'=>$value->id,
        'nom'=>$value->nom.' '.$value->prenom,
        'tel' =>$value->tel,
        'logic_role_depot' => $value->logic_role_depot,
        'stock_personnel' => $this->model->select('g_articles.id as idart,g_articles.code_article,g_articles.nom_article,g_articles.description,g_interne_personnel_stock.id as idStockPerso,g_interne_personnel_stock.qte_stock')->join('g_articles','g_articles.id = g_interne_personnel_stock.articles_id')->Where('g_interne_personnel_stock.users_id',$value->id)->orderBy('idart','ASC')->findAll()

      ];
      array_push($array, $ar);
    }
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $array,
    ]);
  }
  public function stock_personnel_mag($idUsers){

    $data = $this->model->select('g_articles.id as idart,g_articles.code_article, g_articles.nom_article,g_articles.description,g_interne_personnel_stock.id as idStockPerso,g_interne_personnel_stock.qte_stock')->join('g_articles','g_articles.id = g_interne_personnel_stock.articles_id')->Where('g_interne_personnel_stock.users_id',$idUsers)->orderBy('idart','ASC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data
    ]);
  }
  public function injectStockPersonnelManuel(){
    $this->stockPersonnelModel->InjectStockPersonnelAllExisitingMagazinier();
    return $this->respond([
      'status' => $status=200,
      'message' =>$message='Successfully',
      'data'=> $data = null
    ]);

  }


}
