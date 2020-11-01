<?php
namespace App\Models;
use CodeIgniter\Model;

class VillagesModel extends Model{
  protected $table = 'st_village';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','cell_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'name' => 'required|is_unique[st_village.name]',
    'cell_id' => 'required'
  ];
  protected $validationMessages = [
    'name'=>[
      'required' => 'Ce champs est obligatoire',
      'is_unique' => 'Le nom du village existe déjà'
    ],
    'cell_id'=>[
      'required' => 'Veuillez séléctionner une cellule'
    ]

  ];
  protected $returnType ='object';
}
