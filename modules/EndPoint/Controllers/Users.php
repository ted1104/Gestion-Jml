<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\UsersEntity;
use App\Entities\UsersAuthEntity;
use App\Models\UsersAuthModel;



class Users extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\UsersModel';
  protected $userAuthModel = null;

  public function __construct(){
    helper(['global']);
    $this->userAuthModel = new UsersAuthModel();
  }

  public function users_get(){
    $data = $this->model->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function users_create(){
    $this->model->beginTrans();
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
      $dAuth = new UsersAuthEntity($this->request->getPost());
      $dataAuth = [
        'username' => $dAuth->username,
        'password_main' => $dAuth->password_main,
        'password_op' => $dAuth->password_op,
        'users_id' => $this->model->insertID(),
        'status_users_id' => 1
      ];

      if(!$this->userAuthModel->insert($dataAuth)){
        $this->model->RollbackTrans();
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->userAuthModel->errors()
        ];
      }else{
        $status = 200;
        $message = [
          'success' => 'Enregistrement reussi',
          'errors' => null
        ];
        $data = 'null';
      }
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function users_get_by_profile($profile){
    $data = $this->model->Where('roles_id',$profile)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function users_get_by_profile_is_main($profile,$ismain){
    $data = $this->model->Where('roles_id',$profile)->Where('is_main',$ismain)->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
}
