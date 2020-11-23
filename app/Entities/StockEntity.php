<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;
use App\Models\StEtatCritiqueModel;

class StockEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'articles_id' => null,
    'depot_id' => null,
    'qte_stock' => null,
    'logic_etat_critique'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $articlesModel = null;
  protected static $etatcritique = null;
  public function __construct(array $data = null){
    parent::__construct($data);
    self::$articlesModel = new ArticlesModel();
    self::$etatcritique = new StEtatCritiqueModel();

  }

  protected function getArticlesId(){
    return self::$articlesModel->Where('id',$this->attributes['articles_id'])->find();
  }
  protected function getLogicEtatCritique(){

    $etat = self::$etatcritique->find();
    $min = $etat[0]->montant_min;
    $max = $etat[0]->montant_max;
    $qte = $this->attributes['qte_stock'];
    return ($qte <= $min)?'1':($min < $qte && $qte < $max ?'2':'3');
  }







}
