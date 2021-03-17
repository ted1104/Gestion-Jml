<?php
namespace App\Models;
use CodeIgniter\Model;

class ClientModel extends Model{
  protected $table = 'g_interne_client';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nom_client','prenom_client','telephone_client','	addresse','montant'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'nom_client' => 'required',
    'prenom_client' => 'required',
    'telephone_client' => 'required',
    'addresse' => 'required',
  ];
  protected $validationMessages = [
    'nom_client'=>['required' => 'Le nom du client est obligatoire',],
    'prenom_client'=>['required' => 'Le prénom du client est obligatoire'],
    'telephone_client'=>['required' => 'Le téléphone du client est obligatoire'],
    'addresse'=>['required' => 'L\'adresse du client est obligatoire'],
  ];
  protected $returnType ='App\Entities\ClientEntity';
}
