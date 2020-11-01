<?php
namespace App\Models;
use CodeIgniter\Model;
class PropertiesModel extends Model{
  protected $table = 'o_properties';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['address','etage','saloon','bedrooms','bathrooms','toilet','cooked','annexe','waterTank','parking','jardin','surface','price','fully','province_id','district_id','sector_id','cell_id','village_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'address' => 'required',
    'etage' => 'required|numeric',
    'saloon' => 'required|numeric',
    'bedrooms' => 'required|numeric',
    'bathrooms' =>'required|numeric',
    'toilet' =>'required|numeric',
    'cooked' =>'required|numeric',
    'annexe' =>'required|numeric',
    'waterTank' =>'required|numeric',
    'parking' =>'required|numeric',
    'jardin' =>'required|numeric',
    'surface' =>'required',
    'price' =>'required|numeric',
    'province_id' =>'required',
    'district_id' =>'required',
    'sector_id' =>'required',
    'cell_id' =>'required',
    'village_id' =>'required',
    'fully' => 'required'
  ];
	protected $validationMessages = [
      'address'=>['required' => 'The field address is required'],
      'etage'=>[
        'required' => 'The field etage is required',
        'numeric'=>'The field etage must contain a numeric value'
      ],
      'saloon'=>[
        'required' => 'The field saloon is required',
        'numeric'=>'The field saloon must contain a numeric value'
      ],
      'bedrooms'=>[
        'required' => 'The field bedrooms is required',
        'numeric'=>'The field bedrooms must contain a numeric value'
      ],
      'bathrooms'=>[
        'required' => 'The field bathrooms is required',
        'numeric'=>'The field bathrooms must contain a numeric value'
      ],
      'toilet'=>[
        'required' => 'The field toilet is required',
        'numeric'=>'The field toilet must contain a numeric value'
      ],
      'cooked'=>[
        'required' => 'The field cooked is required',
        'numeric'=>'The field numeric must contain a numeric value'
      ],
      'annexe'=>[
        'required' => 'The field annexe is required',
        'numeric'=>'The field annexe must contain a numeric value'
      ],
      'waterTank'=>[
        'required' => 'The field water tank is required',
        'numeric'=>'The field water tank must contain a numeric value'
      ],
      'parking'=>[
        'required' => 'The field parking is required',
        'numeric'=>'The field parking must contain a numeric value'
      ],
      'jardin'=>[
        'required' => 'The field jardin is required',
        'numeric'=>'The field jardin must contain a numeric value'
      ],
      'surface'=>[
        'required' => 'The field surface is required',
        'numeric'=>'The field surface must contain a numeric value'
      ],
      'price'=>[
        'required' => 'The field price is required',
        'numeric'=>'The field price must contain a numeric value'
      ],
      'province_id' => ['required' => 'The field province is required'],
      'district_id' => ['required' => 'The field district is required'],
      'sector_id' => ['required' => 'The field sector is required'],
      'cell_id' => ['required' => 'The field cell is required'],
      'village_id' => ['required' => 'The field village is required'],
      'fully' => ['required' => 'The field Fully is required'],
  ];
  protected $returnType ='App\Entities\PropertyEntity';


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
