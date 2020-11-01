<?php
namespace App\Models;
use CodeIgniter\Model;

class ProvincesModel extends Model{
  protected $table = 'st_province';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'name' => 'required|is_unique[st_province.name]',
  ];
  protected $validationMessages = [
    'name'=>[
              'required' => 'Ce champs est obligatoire',
              'is_unique' => 'Le nom de la province existe déjà'
            ],

  ];
  protected $returnType ='object';
}
