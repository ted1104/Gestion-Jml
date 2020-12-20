<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;



class ApprovisionnementsDetailEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'approvisionnement_id' => null,
    'articles_id' => null,
    'qte' => null,
    'qte_total'=> null,
    'qte_pv'=> null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected $articlesModel = null;



  public function __construct(array $data = null){
    parent::__construct($data);
    $this->articlesModel = new ArticlesModel();

  }
  public function getArticlesId(){
    return $this->articlesModel->Where('id',$this->attributes['articles_id'])->findAll();
  }




}
