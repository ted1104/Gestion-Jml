<?php
namespace App\Models;
use CodeIgniter\Model;

class SectorsModel extends Model{
  protected $table = 'st_sectors';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','district_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'name' => 'required|is_unique[st_sectors.name]',
    'district_id' => 'required'
  ];
  protected $validationMessages = [
    'name'=>[
      'required' => 'Ce champs est obligatoire',
      'is_unique' => 'Le nom du secteur existe déjà'
    ],
    'district_id'=>[
      'required' => 'Veuillez séléctionner un district'
    ]

  ];
  protected $returnType ='object';
}
