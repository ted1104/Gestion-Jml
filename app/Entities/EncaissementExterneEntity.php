<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;


class EncaissementExterneEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'montant_encaissement' => null,
    'users_id' => null,
    'motif' => null,
    'date_encaissement' => null,
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
  public function setDateEncaissement(){
    $d = Time::today();
    $this->attributes['date_encaissement'] = $d;
    return $this;
  }
  public function getUsersId(){
    return $this->userModel->select("id,nom,prenom")->find($this->attributes['users_id']);
  }

  public function getDateEncaissement(){
    return $this->attributes['created_at'];
  }






}
