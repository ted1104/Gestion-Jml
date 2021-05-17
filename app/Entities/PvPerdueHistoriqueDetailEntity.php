<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\CommandesModel;
use App\Models\ArticlesModel;
use App\Models\StockModel;
use App\Models\AretirerModel;


class PvPerdueHistoriqueDetailEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'vente_id' => null,
    'articles_id' => null,
    'qte_perdue' => null,
  ];

  protected $datamap = [];
  // protected $dates = ['created_at', 'updated_at','deleted_at'];
  protected $articlesModel = null;





  public function __construct(array $data = null){
    parent::__construct($data);
    $this->articlesModel = new ArticlesModel();

  }
  public function getArticlesId(){
    return $this->articlesModel->select('id,code_article,nom_article')->Where('id',$this->attributes['articles_id'])->findAll();
  }





}
