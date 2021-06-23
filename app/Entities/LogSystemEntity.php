<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\LogSystemActionModel;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;


class LogSystemEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'users_id' => null,
    'action_id' => null,
    'time_ago' => null,
    'custom_error_message'=>null,
    'attribute' =>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected $dates = ['created_at', 'updated_at', 'deleted_at'];
  protected static $logSystemActionModel = null;
  protected static $userModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    self::$logSystemActionModel = new LogSystemActionModel();
    self::$userModel = new UsersModel();
  }
  public function getUsersId(){
    $data = $this->attributes['users_id'] ? self::$userModel->select('id,nom,prenom')->find($this->attributes['users_id']): "Système";
    $name = $this->attributes['users_id'] ? $data->nom.' '.$data->prenom : $data;
    return $name;
  }
  public function getActionID(){
    return self::$logSystemActionModel->select('id,name,severite')->find($this->attributes['action_id']);
  }
  public function getCustomErrorMessage(){
    $data = self::$logSystemActionModel->select('id,name,description,severite')->find($this->attributes['action_id']);
    $message = $data->description;

    $nom = $this->attributes['users_id'] ? self::$userModel->select('id,nom,prenom')->find($this->attributes['users_id']): "Système";
    $name = $this->attributes['users_id'] ? $nom->nom.' '.$nom->prenom : $nom;

    $heure = explode(" ",$this->attributes["created_at"]);

    $messageIntegrate = str_replace("###",$name,$message);
    $messageIntegrate = str_replace("$$$",$heure[1],$messageIntegrate);

    return [
      "message" => $messageIntegrate,
      "date" => $heure[0]
    ];
  }
  public function getTimeAgo(){
    return Time::parse($this->attributes['created_at'], 'Africa/Bujumbura')->humanize();
  }

  // public function getLogicArticleStock(){
  //   return self::$stockModel->select('id,articles_id,depot_id,qte_stock,qte_stock_virtuel,logic_etat_critique')->Where('depot_id',$this->attributes['id'])->findAll();
  // }
  //
  // public function getResponsableId(){
  //   $data = self::$userModel->select('id,nom,prenom')->Where('id',$this->attributes['responsable_id'])->find();
  //   return $data[0]->nom.' '.$data[0]->prenom;
  // }


}
