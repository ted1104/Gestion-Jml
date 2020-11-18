<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;

class ApprovisionnementsEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'date_approvisionnement' => null,
    'depots_id' => null,
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
  // public function getUsersId(){
  //   return $this->userModel->find($this->attributes['users_id']);
  // }
  // public function getLogicDetailData(){
  //   return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }



}
