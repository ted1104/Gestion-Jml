<?php
namespace App\Models;
use CodeIgniter\Model;


class StEtatCritiqueModel extends Model{
  protected $table = 'st_etat_critique';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['montant_min','montant_max'];
  protected $useTimestamps = false;
  protected $validationRules = [
    'montant_min' => 'required|integer',
    'montant_max' => 'required|integer',
  ];
  protected $validationMessages = [
    'montant_min'=>[
      'required'=>'Le nombre minimum critique est obligatoire',
      'integer'=> 'Le nombre minimu invalide'
    ],
    'montant_max'=>[
      'required'=>'Le nombre maximum critique est obligatoire',
      'integer'=> 'Le nombre minimu invalide'
    ]
  ];
  protected $returnType ='object';

}
