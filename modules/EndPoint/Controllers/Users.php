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

  public function users_get($limit,$offset){
    $data = $this->model->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all' => count($this->model->findAll())
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
      'montantAllCaissier' => $this->model->getSommeAllCaissier()
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
  public function user_account_enable_disable($iduser){
    $data = $this->userAuthModel->Where('users_id',$iduser)->find();
    $newStatus = $data[0]->status_users_id==1?2:1;
    if(!$this->userAuthModel->update($data[0]->id,['status_users_id'=>$newStatus])){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ['Echec d\update du statut du compte']
      ];
    }else{
      $status = 200;
      $message = [
        'success' => $newStatus==1?'Compte activé avec succès':'Compte bloqué avec succès',
        'errors' => null
      ];
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => null
    ]);

  }
  public function user_account_reset_password($iduser){
    $data = $this->userAuthModel->Where('users_id',$iduser)->find();
    $pass = 1234;
    $newPassword = password_hash($pass, PASSWORD_DEFAULT);
    if(!$this->userAuthModel->update($data[0]->id,['password_main'=>$newPassword,'password_op'=>$newPassword])){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ['Echec d\update du mot de passe']
      ];
    }else{
      $status = 200;
      $message = [
        'success' => 'Mot de passe principal et des opérations reunitialisés avec succès',
        'errors' => null
      ];
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => null
    ]);

  }
  public function user_update_profile_picture(){
    $dataFile = $this->request->getFile('main_image');
    $iduser = $this->request->getPost('iduser');
    $nameMainFile = $dataFile->getRandomName();
    if(!$dataFile->move('uploads/profiles', $nameMainFile)){
       $status = 400;
       $message = [
         'success' => null,
         'errors' => 'Echec de chargement de l\'image de profile'
       ];
       }else{
         if($this->model->update($iduser,['photo'=> $nameMainFile])){
           $status = 200;
           $message = [
             'success' => 'L\'image du profile a été bien mis à jour',
             'errors' => null
           ];
         }else{
           $status = 400;
           $message = [
             'success' => null,
             'errors' => 'Echec de chargement de l\'image de profile'
           ];
         }
      }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => null
    ]);
  }

}
