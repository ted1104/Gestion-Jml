<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\ArticlesConfigFaveurModel;

class ArticlesEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'code_article' => null,
    'nom_article' => null,
    'poids' => null,
    'description' => null,
    'users_id' => null,
    'nombre_piece'=> null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_detail_data' => null,
    'logic_config_article_faveur' => null
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $articlesConfigFaveurModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->articlesConfigFaveurModel = new ArticlesConfigFaveurModel();
  }
  public function getUsersId(){
    return $this->userModel->find($this->attributes['users_id']);
  }
  public function getLogicDetailData(){
    return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  }
  public function getLogicConfigArticleFaveur(){
    return $this->articlesConfigFaveurModel->Where('articles_id',$this->attributes['id'])->findAll();
  }




}
