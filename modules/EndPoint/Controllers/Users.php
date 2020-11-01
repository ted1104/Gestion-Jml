<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\UsersEntity;


class Users extends ResourceController {
  protected $modelName = '\App\Models\UsersModel';
  protected $format = 'json';

  public function __construct(){
    helper(['global']);
  }
  public function index(){
    $data = $this->model->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,

    ]);
  }

  public function create_user(){
    $data = new UsersEntity($this->request->getPost());
    $insertData = $this->model->insert($data);
    if(!$insertData){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
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


  // $originaldata = [];
  //
  // foreach ($data as $key => $value) {
  //   $newArray = [
  //     'user'=>$data[$key],
  //     'produit' => [
  //       'id' => 1,
  //       'name' => 'Coca cola'
  //     ]
  //   ];
  //   array_push($originaldata,$newArray);
  // }


}
