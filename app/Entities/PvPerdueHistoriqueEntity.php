<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;
use App\Models\StEtatCritiqueModel;
use App\Models\UsersModel;
use App\Models\StDepotModel;
use App\Models\PvPerdueHistoriqueDetailModel;


class PvPerdueHistoriqueEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'depots_id' => null,
    'magaz_source_id' => null,
    'date_historique' => null,
    'users_id' =>null,
    'note' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_detail_historique' => null
  ];

  protected $datamap = [];
  protected static $userModel = null;
  protected static $depotModel = null;
  protected $pvPerdueHistoriqueDetailModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    self::$userModel = new UsersModel();
    self::$depotModel = new StDepotModel();
    $this->pvPerdueHistoriqueDetailModel = new PvPerdueHistoriqueDetailModel();

  }
  public function getUsersId(){
    return self::$userModel->select('id,nom,prenom')->Where('id',$this->attributes['users_id'])->find();
  }
  public function getMagazSourceId(){
    return self::$userModel->select('id,nom,prenom')->Where('id',$this->attributes['magaz_source_id'])->find();
  }
  public function getDepotsId(){
    return self::$depotModel->select('id,nom')->Where('id',$this->attributes['depots_id'])->find();
  }
  public function getLogicDetailHistorique(){
    return $this->pvPerdueHistoriqueDetailModel->select('id,pv_historique_id,articles_id,qte_perdue')->Where('pv_historique_id',$this->attributes['id'])->findAll();
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
