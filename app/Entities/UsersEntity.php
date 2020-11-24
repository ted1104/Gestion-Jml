<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\CaisseModel;

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
    'logic_montant_caisse'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $caisseModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    self::$caisseModel = new CaisseModel();


  }

  public function setPassword(String $pass){
    $this->attributes['password'] = password_hash($pass, PASSWORD_DEFAULT);
    return $this;
  }


  public function getLogicMontantCaisse(){
    $data = self::$caisseModel->Where('users_id',$this->attributes['id'])->find();
    $montant = 0;
    if($data){
      $montant = $data[0]->montant;
    }
    return $montant;
  }

  // public function getIsMain(){
  //   return $this->attributes['is_main']==1?'PRINCIPAL':'SECONDAIRE';
  // }


}
