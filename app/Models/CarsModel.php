<?php
namespace App\Models;
use CodeIgniter\Model;
class CarsModel extends Model{
  protected $table = 'o_cars';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['mark','kilometrage','moteur','annee_fabrication','fuel','steeling','coleur','transimission','doors','seating','engine_size','price','logic_main_image','logic_list_image'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'mark' => 'required',
    'kilometrage' => 'required',
    'moteur' => 'required',
    'annee_fabrication' => 'required|numeric',
    'fuel' => 'required',
    'steeling' =>'required',
    'coleur' =>'required',
    'transimission' =>'required',
    'seating' =>'required|numeric',
    'doors' =>'required|numeric',
    'engine_size' =>'required',
    'price' =>'required'
  ];
	protected $validationMessages = [
      'mark'=>['required' => 'The field mark is required'],
      'kilometrage'=>[
        'required' => 'The field kilometrage is required',
      ],
      'moteur'=>[
        'required' => 'The field moteur is required',
      ],
      'annee_fabrication'=>[
        'required' => 'The field year is required',
        'numeric'=>'The field year must contain a numeric value'
      ],
      'steeling'=>[
        'required' => 'The field steeling is required',
      ],
      'coleur'=>[
        'required' => 'The field coleur is required',
      ],
      'transimission'=>[
        'required' => 'The field transmission is required',
      ],
      'fuel'=>[
        'required' => 'The field fuel is required',
      ],
      'seating'=>[
        'required' => 'The field seats tank is required',
        'numeric'=>'The field water tank must contain a numeric value'
      ],
      'doors'=>[
        'required' => 'The field doors is required',
        'numeric'=>'The field doors must contain a numeric value'
      ],
      'engine_size'=>[
        'required' => 'The field engine size is required',
      ],
      'price'=>[
        'required' => 'The field price is required',
        'numeric'=>'The field price must contain a numeric value'
      ],
  ];
  protected $returnType ='App\Entities\CarsEntity';


// LES TRANSACTIONS
  public function beginTrans(){
    $this->db->transBegin();
  }
  public function RollbackTrans(){
    $this->db->transRollback();
  }
  public function commitTrans(){
    $this->db->transCommit();
  }
}
