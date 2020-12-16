<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\CaisseModel;
use App\Models\StProfileModel;
use App\Models\StDepotModel;
use App\Models\UsersAuthModel;

class UsersEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'nom' => null,
    'prenom' => null,
    'sexe' => null,
    'dob' => null,
    'tel' => null,
    'roles_id' => null,
    'depot_id' => null,
    'logic_role' => null,
    'date_debut_service' =>null,
    'date_fin_service' =>null,
    'is_main'=>null,
    'photo'=>null,
    'logic_montant_caisse'=>null,
    'logic_role_depot'=>null,
    'logic_auth'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,

  ];

  protected static $caisseModel = null;
  protected static $stProfileModel = null;
  protected static $stDepotModel = null;
  protected static $usersAuthModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    self::$caisseModel = new CaisseModel();
    self::$stProfileModel = new StProfileModel();
    self::$stDepotModel = new StDepotModel();
    self::$usersAuthModel = new UsersAuthModel();
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
  public function getLogicRoleDepot(){
    $array = [
      'role'=>self::$stProfileModel->Where('id', $this->attributes['roles_id'])->find(),
      'depot' => self::$stDepotModel->getWhere(['id'=>$this->attributes['depot_id']])->getRow()
    ];
    return $array;
  }
  public function setPhoto(String $photo){

    $this->attributes['photo'] = 'default.png';
    return $this;

  }
  public function getLogicAuth(){
    $data = self::$usersAuthModel->getWhere(['users_id' => $this->attributes['id']])->getRow();
    return $data;
  }
}
