<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Models\StockPersonnelModel;

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
  protected $stockPersonnelModel = null;



  public function __construct(){
    helper(['global']);
    $this->stockPersonnelModel = new StockPersonnelModel();

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
