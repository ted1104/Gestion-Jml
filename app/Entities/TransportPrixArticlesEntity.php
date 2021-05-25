<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\StZoneModel;
// use App\Models\UsersModel;


class TransportPrixArticlesEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'zone_id' => null,
    'article_id' => null,
    'prix' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $zoneModel = null;
  // protected static $userModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    self::$zoneModel = new StZoneModel();
    // self::$userModel = new UsersModel();

  }
  public function getZoneId(){
    return self::$zoneModel->select('id, nom')->Where('id', $this->attributes['zone_id'])->find();
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
