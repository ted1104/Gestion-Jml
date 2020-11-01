<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\JobsEntity;
use App\Models\ImageSecondairesModel;

class Jobs extends ResourceController {
  protected $modelName = '\App\Models\JobsModel';
  protected $format = 'json';
  protected $imageSecondaireModel = null;


  public function __construct(){
    helper(['global']);
    $this->imageSecondaireModel = new ImageSecondairesModel();
  }

  public function index(){
    $data = $this->model->orderBy('id','DESC')->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }

  public function jobs_create(){
    $this->model->beginTrans();
    $data = $this->request->getPost();
    $dataFile = $this->request->getFile('main_image');
    $dataFiles = $this->request->getFileMultiple('input-file-other');
      if($insertData = $this->model->insert(new JobsEntity($data))){
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
          'type_id'=> 5,
          'is_main' => true
        ];
        array_push($dataArrayImageSecondaire,$arrMainImage);
        foreach ($dataFiles as $file) {
          $nameF = $file->getRandomName();
          $file->move('uploads/attachments', $nameF);
          $arr =[
            'image_file'=> $nameF,
            'element_id' =>$insertData,
            'type_id'=> 5,
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

  public function jobs_get_one($id){
    $data = $this->model->find($id);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data
    ]);
  }
}
