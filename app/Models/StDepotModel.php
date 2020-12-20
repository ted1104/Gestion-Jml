<?php
namespace App\Models;
use CodeIgniter\Model;


class StDepotModel extends Model{
  protected $table = 'st_depots';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nom','adresse','responsable_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'nom' => 'required|is_unique[st_depots.nom]',
    'responsable_id' => 'required'
  ];
  protected $validationMessages = [
    'nom'=>[
              'required' => 'Le nom descriptif du dépôt est obligatoire',
              'is_unique' => 'Ce nom descriptif du dépôt existe déjà'
            ],
    'responsable_id'=>[
              'required' => 'Le responsable est obligatoire',
            ],
];
  protected $returnType ='App\Entities\StDepotEntity';

}
