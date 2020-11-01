<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ProvincesModel;
use CodeIgniter\I18n\Time;

class PropertyEntity extends Entity{
  protected $provincesModel = null;
  protected $attributes = [
    'address' => null,
    'etage' => null,
    'saloon' => null,
    'bedrooms' => null,
    'bathrooms' =>null,
    'toilet' =>null,
    'cooked' =>null,
    'annexe' =>null,
    'waterTank' =>null,
    'parking' =>null,
    'jardin' =>null,
    'surface' =>null,
    'price' =>null,
    'province_id' =>null,
    'district_id' =>null,
    'sector_id' =>null,
    'cell_id' =>null,
    'village_id' =>null,
    'fully' => null,
    'created_at' => null
  ];

  protected $datamap = [
    // 'full_name_app'=> 'name',


  ];

  public function getCreatedAt(string $format = 'Y-m-d'){
    // $this->attributes['created_at'] = $this->mutateDate($this->attributes['created_at']);
    // $this->attributes['created_at'] = explode('.',$this->attributes['created_at']->format($format));
    return $this->attributes['created_at'];
  }
  // public function __construct(){
  //     $this->provincesModel = new ProvincesModel();
  // }
  //
  // public function getFully(){
  //   // $this->attributes[]
  //   return 'Papa';
  // }
  //
  // public function getProvinceId(){
  //   $v = $this->provincesModel->getWhere(['id'=>$this->attributes['province_id']])->getRow();
  //   return $v;
  // }

}
