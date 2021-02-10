<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\ArticlesConfigFaveurModel;
use App\Models\PvRestaurationModel;
use App\Models\StockModel;


class ArticlesEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'code_article' => null,
    'nom_article' => null,
    'poids' => null,
    'description' => null,
    'users_id' => null,
    'nombre_piece'=> null,
    'qte_stock_pv' => null,
    'pv_en_kg' => null,
    'is_eligible_add_kg' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_detail_data' => null,
    'logic_config_article_faveur' => null,
    'logic_operation_pv_restaurer' => null,
    'logic_qte_virtuel_dispo' => null
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $articlesConfigFaveurModel = null;
  protected $pvRestaurationModel = null;
  protected $stockModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->articlesConfigFaveurModel = new ArticlesConfigFaveurModel();
    $this->pvRestaurationModel = new PvRestaurationModel();
    $this->stockModel = new StockModel();
  }
  public function getUsersId(){
    return $this->userModel->select('id,nom,prenom')->find($this->attributes['users_id']);
  }
  public function getLogicDetailData(){
    return $this->articlesPrixModel->select('id,articles_id,prix_unitaire,qte_decideur_min,qte_decideur_max')->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  }
  public function getLogicConfigArticleFaveur(){
    return $this->articlesConfigFaveurModel->Where('articles_id',$this->attributes['id'])->findAll();
  }
  public function getLogicOperationPvRestaurer(){
    return $this->pvRestaurationModel->Where('articles_id', $this->attributes['id'])->findAll();
  }
  public function getLogicQteVirtuelDispo(){
    return $this->stockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$this->attributes['id'])->find()[0]->qte_stock_virtuel;
  }




}
