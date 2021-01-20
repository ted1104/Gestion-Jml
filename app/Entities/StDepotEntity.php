<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\StockModel;
use App\Models\UsersModel;


class StDepotEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'nom' => null,
    'responsable_id' => null,
    'is_central' => null,
    'adresse'=> null,
    'logic_article_stock'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $stockModel = null;
  protected static $userModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    self::$stockModel = new StockModel();
    self::$userModel = new UsersModel();

  }

  public function getLogicArticleStock(){
    return self::$stockModel->select('id,articles_id,depot_id,qte_stock,qte_stock_virtuel,logic_etat_critique')->Where('depot_id',$this->attributes['id'])->findAll();
  }

  public function getResponsableId(){
    $data = self::$userModel->select('id,nom,prenom')->Where('id',$this->attributes['responsable_id'])->find();
    return $data[0]->nom.' '.$data[0]->prenom;
  }






}
