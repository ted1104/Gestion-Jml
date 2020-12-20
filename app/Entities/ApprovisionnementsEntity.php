<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\StDepotModel;
use App\Models\ApprovisionnementsDetailModel;


class ApprovisionnementsEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'plaque_vehicule'=>null,
    'nom_chauffeur' => null,
    'telephone_chauffeur' => null,
    'numero_bordereau' => null,
    'date_approvisionnement' => null,
    'depots_id' => null,
    'users_id' => null,
    'logic_data_article'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $depotModel = null;
  protected $approvisionnementsDetailModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->depotModel = new StDepotModel();
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
  }
  public function getUsersId(){
    return $this->userModel->find($this->attributes['users_id']);
  }
  public function getDepotsId(){
    return $this->depotModel->Where('id',$this->attributes['depots_id'])->find();
  }
  public function getLogicDataArticle(){
    return $this->approvisionnementsDetailModel->Where('approvisionnement_id',$this->attributes['id'])->findAll();
  }
  public function getDateApprovisionnement(){
    return $this->attributes['created_at'];
  }
  // public function getLogicDetailData(){
  //   return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }



}
