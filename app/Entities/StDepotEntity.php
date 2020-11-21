<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\StockModel;

class StDepotEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'nom' => null,
    'adresse'=> null,
    'logic_article_stock'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $stockModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    self::$stockModel = new StockModel();

  }

  public function getLogicArticleStock(){
    return self::$stockModel->Where('depot_id',$this->attributes['id'])->findAll();
  }




}
