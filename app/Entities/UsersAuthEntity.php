<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;

class UsersAuthEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'username' => null,
    'password_main' => null,
    'password_op' => null,
    'users_id' => null,
    'role_id' => null,
    'status_users_id' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];
  protected $datamap = [];
  protected $userModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
  }

  public function setPasswordMain(String $pass){
    if(empty($pass)){
      return;
    }
    $this->attributes['password_main'] = password_hash($pass, PASSWORD_DEFAULT);
    return $this;

  }
  public function setPasswordOp(String $pass){
    if(empty($pass)){
      return;
    }
    $this->attributes['password_op'] = password_hash($pass, PASSWORD_DEFAULT);
    return $this;
  }
  public function getUsersId(){
    return $this->userModel->select('id, nom, prenom,roles_id,depot_id,is_main,photo,logic_droit_access')->Where('id',$this->attributes['users_id'])->find();
  }


}
