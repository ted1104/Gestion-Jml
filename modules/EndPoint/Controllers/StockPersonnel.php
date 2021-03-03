<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StockPersonnelModel;
use App\Models\TransfertStockDetailModel;

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



  public function __construct(){
    helper(['global']);
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->transfertStockDetailModel = new TransfertStockDetailModel();

  }
  public function stock_personnel_get($dateFilter,$limit, $offset){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_transfert'=> $dateFilter];
    $data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function stock_personnel_mag($idUsers){
    // $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->Where('g_interne_vente_historique_status.status_vente_id',2)->Where('depots_id',$idDepot)->findAll();
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
