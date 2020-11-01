<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\PropertyEntity;
use App\Models\ImageSecondairesModel;

use App\Models\ProvincesModel;
use App\Models\DistrictsModel;
use App\Models\SectorsModel;
use App\Models\CellsModel;
use App\Models\VillagesModel;



class Properties extends ResourceController {
  protected $modelName = '\App\Models\PropertiesModel';
  protected $format = 'json';
  protected $imageSecondaireModel = null;
  protected $provincesModel = null;
  protected $districtsModel = null;
  protected $sectorsModel = null;
  protected $cellsModel = null;
  protected $villagesModel = null;

  public function __construct(){
    helper(['global']);
    $this->imageSecondaireModel = new ImageSecondairesModel();
    $this->provincesModel = new ProvincesModel();
    $this->districtsModel = new DistrictsModel();
    $this->sectorsModel = new SectorsModel();
    $this->cellsModel = new CellsModel();
    $this->villagesModel = new VillagesModel();
  }

  public function index(){
    $data = $this->model->orderBy('id','DESC')->findAll();
    $allData = [];

    foreach ($data as $key => $value) {
      $arr = [
        'property' => $value,
        'images'=>[
          'main' => $this->imageSecondaireModel->getWhere(['element_id'=>$value->id,'is_main'=> 1,'type_id'=>1])->getRow(),
          'others' =>[]
        ],
        'province' => $this->provincesModel->find($value->province_id),
        'district' => $this->districtsModel->find($value->district_id),
        'sector' => $this->sectorsModel->find($value->sector_id),
        'cell' => $this->cellsModel->find($value->cell_id),
        'village' => $this->villagesModel->find($value->village_id),
      ];
      array_push($allData, $arr);
    }
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $allData,
    ]);
  }

  public function properties_create(){
    $this->model->beginTrans();
    $data = $this->request->getPost();
    $dataFile = $this->request->getFile('main_image');
    $dataFiles = $this->request->getFileMultiple('input-file-other');
      if($insertData = $this->model->insert(new PropertyEntity($data))){
        $dataArrayImageSecondaire = [];
        $nameMainFile = $dataFile->getRandomName();
        if(!$dataFile->move('uploads/images', $nameMainFile)){
          $this->model->RollbackTrans();
          $status = 400;
          $message = [
            'success' => null,
            'errors' => 'Main image upload failed'
          ];
        }else{
        $arrMainImage =[
          'image_file'=> $nameMainFile,
          'element_id' =>$insertData,
          'type_id'=> 1,
          'is_main' => true
        ];
        array_push($dataArrayImageSecondaire,$arrMainImage);
        foreach ($dataFiles as $file) {
          $nameF = $file->getRandomName();
          $file->move('uploads/images', $nameF);
          $arr =[
            'image_file'=> $nameF,
            'element_id' =>$insertData,
            'type_id'=> 1,
            'is_main' => false
          ];
          array_push($dataArrayImageSecondaire,$arr);
        }
        if(!$this->imageSecondaireModel->insertBatch($dataArrayImageSecondaire)){
          $this->model->RollbackTrans();
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>$this->imageSecondaireModel->errors(),
          ];
        }
          $status = 200;
          $message = [
            'success' => 'Successfully saved',
            'errors' => null
          ];
        }

      }else{
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->model->errors(),
        ];
      }

    $this->model->commitTrans();
    return $this->respond([
      'status' => $status,
      'message' =>$message,
    ]);
  }

  public function propertie_get_one($id){
    $data = $this->model->find($id);

    $dataSimulaire = $this->model->getWhere(['id !='=>$id])->getResult();
    $dataSimulaireArray = [];
    foreach ($dataSimulaire as $key => $value) {
      $newArray = [
        'property' =>$value,
        'image_main' => $this->imageSecondaireModel->getWhere(['element_id'=>$value->id,'is_main'=> 1,'type_id'=>1])->getRow()
      ];

      array_push($dataSimulaireArray,$newArray);
    }

      $arr = [
        'property' => $data,
        'images'=>[
          'main' => $this->imageSecondaireModel->getWhere(['element_id'=>$data->id,'is_main'=> 1,'type_id'=>1])->getRow(),
          'others' =>$this->imageSecondaireModel->getWhere(['element_id'=>$data->id,'is_main'=> 0,'type_id'=>1])->getResult()
        ],
        'province' => $this->provincesModel->find($data->province_id),
        'district' => $this->districtsModel->find($data->district_id),
        'sector' => $this->sectorsModel->find($data->sector_id),
        'cell' => $this->cellsModel->find($data->cell_id),
        'village' => $this->villagesModel->find($data->village_id),
        'simulaire' => $dataSimulaireArray
      ];

    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $arr,
    ]);
  }
}
