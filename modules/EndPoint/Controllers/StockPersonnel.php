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




class StockPersonnel extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\StockPersonnelModel';
  // protected $approvisionnementsDetailModel = null;
  // protected $stockModel = null;
  // protected $articlesModel = null;
  // protected $pvRestaurationModel = null;
  // protected $clotureStockModel = null;


  public function __construct(){
    helper(['global']);
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    // $this->stockModel = new StockModel();
    // $this->articlesModel = new ArticlesModel();
    // $this->pvRestaurationModel = new PvRestaurationModel();
    // $this->clotureStockModel = new ClotureStockModel();
  }
  // public function approvisionnement_get($dateFilter,$limit, $offset){
  //   $d = Time::today();
  //   if($dateFilter == "null"){ $dateFilter = $d; }
  //   $conditionDate =['date_approvisionnement'=> $dateFilter];
  //   $data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll($limit,$offset);
  //   return $this->respond([
  //     'status' => 200,
  //     'message' => 'success',
  //     'data' => $data,
  //     'all'=> count($data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll())
  //   ]);
  // }

}
