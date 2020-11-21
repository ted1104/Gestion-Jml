<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;

class StockEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'articles_id' => null,
    'depot_id' => null,
    'qte_stock' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $articlesModel = null;
  public function __construct(array $data = null){
    parent::__construct($data);
    self::$articlesModel = new ArticlesModel();

  }

  public function getArticlesId(){
    return self::$articlesModel->Where('id',$this->attributes['articles_id'])->find();
  }







}
