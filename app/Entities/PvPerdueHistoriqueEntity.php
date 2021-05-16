<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;
use App\Models\StEtatCritiqueModel;
use App\Models\UsersModel;

class PvPerdueHistoriqueEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'depots_id' => null,
    'magaz_source_id' => null,
    'articles_id'=>null,
    'qte_perdue' => null,
    'users_id' =>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected static $userModel = null;
  public function __construct(array $data = null){
    parent::__construct($data);
    self::$userModel = new UsersModel();
    // self::$etatcritique = new StEtatCritiqueModel();

  }
  public function getUsersId(){
    return self::$userModel->select('id,nom,prenom')->Where('id',$this->attributes['users_id'])->find();
  }
  //
  // protected function getArticlesId(){
  //   return self::$articlesModel->select('id,code_article,nom_article,description,logic_detail_data')->Where('id',$this->attributes['articles_id'])->find();
  // }
  // protected function getLogicEtatCritique(){
  //
  //   $etat = self::$etatcritique->find();
  //   $min = $etat[0]->montant_min;
  //   $max = $etat[0]->montant_max;
  //   $qte = $this->attributes['qte_stock_virtuel'];
  //   return ($qte <= $min)?'1':($min < $qte && $qte < $max ?'2':'3');
  // }







}
