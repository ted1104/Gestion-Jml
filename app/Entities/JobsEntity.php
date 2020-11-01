<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;
use App\Models\ImageSecondairesModel;

class JobsEntity extends Entity{
  protected $attributes = [
    'id' =>null,
    'title' => null,
    'description' => null,
    'entreprise' => null,
    'linkapply' => null,
    'datapublished' =>null,
    'deadline' =>null,
    'logic_main_file' => null,
    'logic_list_file' => null
  ];

  protected $datamap = [
    // 'full_name_app'=> 'name',
  ];
  protected $imageSecondaireModel = null;

  public function __construct(array $data = null){
    parent::__construct($data);
    $this->imageSecondaireModel = new ImageSecondairesModel();
  }

  public function getLogicMainFile(){
    return $this->imageSecondaireModel->getWhere(['element_id'=>$this->attributes['id'],'is_main'=> 1,'type_id'=>5])->getRow();
  }
  public function getLogicListFile(){
    return $this->imageSecondaireModel->getWhere(['element_id'=>$this->attributes['id'],'is_main'=> 0,'type_id'=>5])->getResult();
  }


}
