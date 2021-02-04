<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\StDepotModel;
use App\Models\ApprovisionnementsDetailModel;


class PvRestaurationEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'date_restaurer' => null,
    'depots_id_dest' => null,
    'users_id' => null,
    'qte_restaure'=>null,
    'qte_restaure' => null,
    'articles_id' => null,
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
    return $this->userModel->select("id,nom, prenom")->find($this->attributes['users_id']);
  }
  public function getDepotsIdDest(){
    return $this->depotModel->select("id,nom")->Where('id',$this->attributes['depots_id_dest'])->find();
  }

  public function getDateRestaure(){
    return $this->attributes['created_at'];
  }
  // public function getLogicDetailData(){
  //   return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }



}
