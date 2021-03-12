<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;
use App\Models\StMotifDecaissementExterneModel;


class DecaissementExterneEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'users_id_from' => null,
    'destination' => null,
    'montant' => null,
    'date_decaissement' => null,
    'note'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
    'logic_detail_data' => null,
  ];

  protected $datamap = [];
  protected $userModel = null;
  protected $articlesPrixModel = null;
  protected $stMotifDecaissementExterneModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    $this->userModel = new UsersModel();
    $this->stMotifDecaissementExterneModel = new StMotifDecaissementExterneModel();
    // $this->articlesPrixModel = new ArticlesPrixModel();
  }
  public function setDateDecaissement(){
      $d = Time::today();
      $this->attributes['date_decaissement'] = $d;
      return $this;
    }
  public function getUsersIdFrom(){
    return $this->userModel->select('id, nom, prenom')->find($this->attributes['users_id_from']);
  }

  public function getDateDecaissement(){
    return $this->attributes['created_at'];
  }
  public function getDestination(){
    // $self = $this->attributes['destination'];
    // return $self==1?'BANQUE':($self==2?'ACHAT PRODUIT':'AUTRES');
    return $this->stMotifDecaissementExterneModel->find($this->attributes['destination'])->description;
  }




}
