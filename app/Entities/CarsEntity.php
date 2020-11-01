<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ImageSecondairesModel;

class CarsEntity extends Entity{
  protected $attributes = [
    'id' =>null,
    'mark' => null,
    'kilometrage' => null,
    'moteur' => null,
    'annee_fabrication' => null,
    'steeling' =>null,
    'coleur' =>null,
    'transimission' =>null,
    'fuel' =>null,
    'seating' =>null,
    'doors' =>null,
    'engine_size' =>null,
    'price' =>null,
    'logic_main_image' => null,
    'logic_list_image' => null
  ];

  protected $datamap = [
    // 'full_name_app'=> 'name',
  ];
  private $imageSecondaireModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    $this->imageSecondaireModel = new ImageSecondairesModel();
  }
  public function getFuel(){
    return $this->attributes['fuel'] == 1 ?'Essence':'Mazout';
  }
  public function getSteeling(){
    return $this->attributes['steeling'] == 1 ?'Right':'Left';
  }
  public function getTransimission(){
    return $this->attributes['transimission'] == 1 ?'Automatic':'Manual';
  }
  public function getLogicMainImage(){

    return $this->imageSecondaireModel->getWhere(['element_id'=>$this->attributes['id'],'is_main'=> 1,'type_id'=>2])->getRow();
  }
  public function getLogicListImage(){
    // $imageSecondaireModel = new ImageSecondairesModel();
    return $this->imageSecondaireModel->getWhere(['element_id'=>$this->attributes['id'],'is_main'=> 0,'type_id'=>2])->getResult();
  }

}
