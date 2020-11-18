<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;

class UsersEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'nom' => null,
    'prenom' => null,
    'sexe' => null,
    'dob' => null,
    'roles_id' => null,
    'depot_id' => null,
    'date_debut_service' =>null,
    'date_fin_service' =>null,
    'is_main'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];

  public function setPassword(String $pass){
    $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
    return $this;
  }

  // public function getIsMain(){
  //   return $this->attributes['is_main']==1?'PRINCIPAL':'SECONDAIRE';
  // }


}
