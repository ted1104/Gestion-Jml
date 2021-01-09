<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;

class ArticlesConfigFaveurEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'articles_id' => null,
    'prix_id' => null,
    'qte_faveur' => null,
    'users_id' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
  }
  public function getUsersId(){
    return $this->userModel->find($this->attributes['users_id']);
  }
  public function getPrixId(){
    return $this->articlesPrixModel->getWhere(['id'=>$this->attributes['prix_id']])->getResult();
  }
  // public function getLogicConfigArticleFaveur(){
  //   return $this->articlesConfigFaveurModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }




}
