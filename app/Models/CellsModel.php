<?php
namespace App\Models;
use CodeIgniter\Model;

class CellsModel extends Model{
  protected $table = 'st_cell';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','sector_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'name' => 'required|is_unique[st_cell.name]',
    'sector_id' => 'required'
  ];
  protected $validationMessages = [
    'name'=>[
      'required' => 'Ce champs est obligatoire',
      'is_unique' => 'Le nom de la cellule existe déjà'
    ],
    'sector_id'=>[
      'required' => 'Veuillez séléctionner un secteur'
    ]

  ];
  protected $returnType ='object';
}
