<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use App\Models\ArticlesPrixModel;
use App\Models\StDepotModel;
use App\Models\ApprovisionnementsInterDepotDetailModel;


class TransfertStockEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'date_transfert' => null,
    'users_id_source' => null,
    'users_id_dest' => null,
    'users_id' => null,
    'status_operation' => null,
    'logic_data_article'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $depotModel = null;
  protected $approvisionnementsInterDepotDetailModel = null;


  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->depotModel = new StDepotModel();
    $this->approvisionnementsInterDepotDetailModel = new ApprovisionnementsInterDepotDetailModel();
  }
  public function getUsersId(){
    return $this->userModel->find($this->attributes['users_id']);
  }
  public function getUsersIdSource(){
    return $this->userModel->Where('id',$this->attributes['users_id_source'])->find();
  }
  public function getUsersIdDest(){
    return $this->userModel->Where('id',$this->attributes['users_id_dest'])->find();
  }
  // public function getLogicDataArticle(){
  //   return $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id',$this->attributes['id'])->findAll();
  // }
  public function getDateTransfert(){
    return $this->attributes['created_at'];
  }
  // public function getLogicDetailData(){
  //   return $this->articlesPrixModel->getWhere(['articles_id'=>$this->attributes['id']])->getResult();
  // }



}
