<?php
namespace App\Models;
use CodeIgniter\Model;


class StProfileModel extends Model{
  protected $table = 'st_roles';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['description'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'description' => 'required|is_unique[st_roles.description]',
  ];
  protected $validationMessages = [
    'nodescriptionm'=>[
              'required' => 'Le champ description est obligatoire',
              'is_unique' => 'La description du dépôt existe déjà'
            ],
  ];
  protected $returnType ='object';

}
