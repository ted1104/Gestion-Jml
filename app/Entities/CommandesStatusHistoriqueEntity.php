<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ArticlesModel;

class CommandesStatusHistoriqueEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'vente_id' => null,
    'status_vente_id' => null,
    'users_id' => null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_article'=>null
  ];

  protected $datamap = [];
  // protected $dates = ['created_at', 'updated_at','deleted_at'];
  protected $articlesModel = null;



  public function __construct(array $data = null){
    parent::__construct($data);
    $this->articlesModel = new ArticlesModel();

  }

  public function getUsersId(){
    // return $this->userModel->Where('id',$this->attributes['users_id'])->find();
  }






}
