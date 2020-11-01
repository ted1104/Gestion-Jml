<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;


class UsersEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'username' => null,
    'password' => null,
    'name' => null,
    'lastname' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [
    'full_name_app'=> 'name',

  ];

  public function setPassword(String $pass){
    $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
    return $this;
  }
  // public function getPassword(){
  //   return $this->attributes['password'];
  // }

}
