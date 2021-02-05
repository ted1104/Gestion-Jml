<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\CaisseModel;
use App\Models\StProfileModel;
use App\Models\StDepotModel;
use App\Models\UsersAuthModel;
use CodeIgniter\I18n\Time;
use App\Models\CommandesModel;
use App\Models\CommandesDetailModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\DecaissementModel;
use App\Models\EncaissementExterneModel;
use App\Models\DecaissementExterneModel;
use App\Models\DroitAccessModel;




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
    'logic_operation_finance' => null,
    'logic_droit_access' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,

  ];

  protected static $caisseModel = null;
  protected static $stProfileModel = null;
  protected static $stDepotModel = null;
  protected static $usersAuthModel = null;
  protected $commandesModel = null;
  protected $commandeDetailModel = null;
  protected $commandesStatusHistoriqueModel = null;
  protected $decaissementModel  = null;
  protected $encaissementExterneModel = null;
  protected $decaissementExterneModel = null;
  protected $droitAccessModel = null;




  public function __construct(array $data = null){
    parent::__construct($data);
    self::$caisseModel = new CaisseModel();
    self::$stProfileModel = new StProfileModel();
    self::$stDepotModel = new StDepotModel();
    self::$usersAuthModel = new UsersAuthModel();
    $this->commandesModel = new CommandesModel();
    $this->commandeDetailModel = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->decaissementModel = new DecaissementModel();
    $this->encaissementExterneModel = new EncaissementExterneModel();
    $this->decaissementExterneModel = new DecaissementExterneModel();
    $this->droitAccessModel = new DroitAccessModel();
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
      'role'=>self::$stProfileModel->select('id,description')->Where('id', $this->attributes['roles_id'])->find(),
      'depot' => self::$stDepotModel->select('id,nom')->getWhere(['id'=>$this->attributes['depot_id']])->getRow()
    ];
    return $array;
  }
  public function setPhoto(String $photo){

    $this->attributes['photo'] = 'default.png';
    return $this;

  }
  public function getLogicAuth(){
    $data = self::$usersAuthModel->select('id,username,status_users_id')->getWhere(['users_id' => $this->attributes['id']])->getRow();
    return $data;
  }

  public function getLogicOperationFinance(){
    $d = Time::today();
    $d = dateFormating($d);

    $sommesAchatTotal = 0;
    $allVente = $this->commandesStatusHistoriqueModel->Where('status_vente_id',2)->Where('users_id',$this->attributes['id'])->like('created_at',$d,'after')->findAll();
    foreach ($allVente as $key) {
      $detail = $this->commandeDetailModel->Where('vente_id',$key->vente_id)->findAll();
      $sommes= 0;
      foreach ($detail as $key => $value) {
        $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;
        $sommes +=$montant;
      }
      $sommesAchatTotal+=$sommes;
    }

    //ENCAISSEMENT INTERNE : CAISSIER MAIN
    $sommesEncaissementInterne = $this->decaissementModel->selectSum('montant')->Where('users_id_dest',$this->attributes['id'])->Where('date_decaissement',$d)->find();

    //DECAISSEMENT INTERNE : CAISSIER SECONDAIRE
    $sommesDecaissementInterne = $this->decaissementModel->selectSum('montant')->Where('users_id_from',$this->attributes['id'])->Where('date_decaissement',$d)->find();

    //ENCAISSEMENT EXTERNE ; CAISSIER MAIN
    $sommesEncaissementExterne = $this->encaissementExterneModel->selectSum('montant_encaissement')->Where('users_id',$this->attributes['id'])->Where('date_encaissement',$d)->find();

    //DECAISSEMENT INTERNE : CAISSIER MAIN
    $sommesDecaissementExterne = $this->decaissementExterneModel->selectSum('montant')->Where('users_id_from',$this->attributes['id'])->Where('date_decaissement',$d)->find();

      return [
      'achat' => round($sommesAchatTotal,2),
      'encaissementInterne' => $sommesEncaissementInterne[0]->montant?round($sommesEncaissementInterne[0]->montant,2):0,
      'decaissementInterne' => $sommesDecaissementInterne[0]->montant?round($sommesDecaissementInterne[0]->montant,2):0,
      'encaissementExterne' => $sommesEncaissementExterne[0]->montant_encaissement?round($sommesEncaissementExterne[0]->montant_encaissement,2):0,
      'decaissementExterne' => $sommesDecaissementExterne[0]->montant?round($sommesDecaissementExterne[0]->montant,2):0,
      'date' => $d
    ];
  }

  public function getLogicDroitAccess(){
    return $this->droitAccessModel->Where('users_id', $this->attributes['id'])->find();
  }
}
