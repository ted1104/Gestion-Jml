<?php
namespace App\Models;
use CodeIgniter\Model;

class DistrictsModel extends Model{
  protected $table = 'st_district';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','province_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'name' => 'required|is_unique[st_district.name]',
    'province_id' => 'required'
  ];
  protected $validationMessages = [
    'name'=>[
      'required' => 'Ce champs est obligatoire',
      'is_unique' => 'Le nom du district existe déjà'
    ],
    'province_id'=>[
      'required' => 'Veuillez séléctionner une province'
    ]

  ];
  protected $returnType ='object';
}
