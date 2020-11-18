<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
// use App\Models\ArticlesPrixModel;

class DecaissementEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'users_id_from' => null,
    'users_id_dest' => null,
    'montant' => null,
    'date_decaissement' => null,
    'status_operation' => null,
    'note'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_detail_data' => null,
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    // $this->articlesPrixModel = new ArticlesPrixModel();
  }
  public function getUsersIdFrom(){
    return $this->userModel->find($this->attributes['users_id_from']);
  }
  public function getUsersIdDest(){
    // return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
    return $this->userModel->find($this->attributes['users_id_dest']);
  }

  public function getDateDecaissement(){
    return $this->attributes['created_at'];
  }




}
