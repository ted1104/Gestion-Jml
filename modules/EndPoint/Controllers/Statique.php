<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
// use App\Entities\UsersEntity;
use App\Models\ProvincesModel;
use App\Models\DistrictsModel;
use App\Models\SectorsModel;
use App\Models\CellsModel;
use App\Models\VillagesModel;


class Statique extends ResourceController {
  // protected $modelName = '\App\Models\UsersModel';
  protected $format = 'json';
  protected $provincesModel = null;
  protected $districtsModel = null;
  protected $sectorsModel = null;
  protected $cellsModel = null;
  protected $villagesModel = null;

  public function __construct(){
    helper(['global']);
    $this->provincesModel = new ProvincesModel();
    $this->districtsModel = new DistrictsModel();
    $this->sectorsModel = new SectorsModel();
    $this->cellsModel = new CellsModel();
    $this->villagesModel = new VillagesModel();
  }
  /*
  * OPERATIONS TABLE PROVINCES
  */
  public function province_get(){
    $data = $this->provincesModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,

    ]);
  }
  public function province_create(){
    $data = $this->request->getPost();
    $insertData = $this->provincesModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->provincesModel->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' => 'Successfully saved',
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

  /*
  * OPERATIONS TABLE DISTRICTS
  */
  public function district_get(){
    $data = $this->districtsModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function district_create(){
    $data = $this->request->getPost();
    if(checkingForeignKey('st_province','id',$data['province_id'])){
    $insertData = $this->districtsModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->districtsModel->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' => 'Successfully saved',
          'errors' => null
        ];
        $data = $insertData;
      }

    }else{
      $status = 200;
      $message = [
        'success' => null,
        'errors' => ['province_id'=>'La province choisit n\'existe pas']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function district_get_by_province($idProvince){
    $data = $this->districtsModel->getWhere(['province_id' => $idProvince]);
    return $this->respond([
      'status' => '200',
      'message' =>'success',
      'data'=> $data->getResult()
    ]);

  }

  /*
  * OPERATIONS TABLE SECTORS
  */
  public function sectors_get(){
    $data = $this->sectorsModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function sectors_create(){
    $data = $this->request->getPost();
    if(checkingForeignKey('st_district','id',$data['district_id'])){
    $insertData = $this->sectorsModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->sectorsModel->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' => 'Successfully saved',
          'errors' => null
        ];
        $data = $insertData;
      }

    }else{
      $status = 200;
      $message = [
        'success' => null,
        'errors' => ['district_id'=>'Le district choisit n\'existe pas']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function sectors_get_by_district($iddistrict){
    $data = $this->sectorsModel->getWhere(['district_id' => $iddistrict]);
    return $this->respond([
      'status' => '200',
      'message' =>'success',
      'data'=> $data->getResult()
    ]);

  }

  /*
  * OPERATIONS TABLE CELLULES
  */
  public function cells_get(){
    $data = $this->cellsModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function cells_create(){
    $data = $this->request->getPost();
    if(checkingForeignKey('st_sectors','id',$data['sector_id'])){
    $insertData = $this->cellsModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->cellsModel->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' => 'Successfully saved',
          'errors' => null
        ];
        $data = $insertData;
      }

    }else{
      $status = 200;
      $message = [
        'success' => null,
        'errors' => ['sectors_id'=>'Le secteur choisit n\'existe pas']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function cells_get_by_sectors($idsectors){
    $data = $this->cellsModel->getWhere(['sector_id' => $idsectors]);
    return $this->respond([
      'status' => '200',
      'message' =>'success',
      'data'=> $data->getResult()
    ]);

  }

  /*
  * OPERATIONS TABLE VILLAGES
  */
  public function village_get(){
    $data = $this->villagesModel->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function village_create(){
    $data = $this->request->getPost();
    if(checkingForeignKey('st_cell','id',$data['cell_id'])){
    $insertData = $this->villagesModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->villagesModel->errors()
        ];
        $data = null;
      }else{
        $status = 200;
        $message = [
          'success' => 'Successfully saved',
          'errors' => null
        ];
        $data = $insertData;
      }

    }else{
      $status = 200;
      $message = [
        'success' => null,
        'errors' => ['sectors_id'=>'La cellule choisit n\'existe pas']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function village_get_by_cells($idcell){
    $data = $this->villagesModel->getWhere(['cell_id' => $idcell]);
    return $this->respond([
      'status' => '200',
      'message' =>'success',
      'data'=> $data->getResult()
    ]);

  }
}
