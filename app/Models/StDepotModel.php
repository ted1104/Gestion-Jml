<?php
namespace App\Models;
use CodeIgniter\Model;

class StDepotModel extends Model{
  protected $table = 'st_depots';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nom','adresse'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'nom' => 'required|is_unique[st_depots.nom]',
  ];
  protected $validationMessages = [
    'nom'=>[
              'required' => 'Le champ nom est obligatoire',
              'is_unique' => 'Le nom du dépôt existe déjà'
            ],
  ];
  protected $returnType ='object';
}
