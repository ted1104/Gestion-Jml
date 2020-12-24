<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\CommandesModel;
use App\Models\ArticlesModel;
use App\Models\StockModel;


class CommandesDetailEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'vente_id' => null,
    'articles_id' => null,
    'qte_vendue' => null,
    'prix_unitaire' => null,
    'type_prix ' => null,
    'is_negotiate ' => null,
    'prix_negociation'=>null,
    'is_faveur' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_article'=>null,
    'logic_qte_stock_article_depot'=>null,
  ];

  protected $datamap = [];
  // protected $dates = ['created_at', 'updated_at','deleted_at'];
  protected $articlesModel = null;
  protected $stockModel = null;
  protected $commandesModel = null;




  public function __construct(array $data = null){
    parent::__construct($data);
    $this->articlesModel = new ArticlesModel();
    $this->stockModel = new StockModel();
    $this->commandesModel = new CommandesModel();


  }
  public function getArticlesId(){
    return $this->articlesModel->Where('id',$this->attributes['articles_id'])->findAll();
  }
  public function getTypePrix(){
    return $this->attributes['type_prix']==1?'En Gros':'En détail';
  }
  public function getLogicQteStockArticleDepot(){
    $depot = $this->commandesModel->Where('id',$this->attributes['vente_id'])->first();
    $stockqte = $this->stockModel->Where('depot_id',$depot->depots_id[0]->id)->Where('articles_id',$this->attributes['articles_id'])->first();
    return $stockqte->qte_stock_virtuel;

  }






}
