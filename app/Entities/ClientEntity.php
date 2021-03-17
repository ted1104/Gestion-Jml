<?php namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;

class ClientEntity extends Entity{

  protected $attributes = [
    'id' => null,
    'nom_client' => null,
    'prenom_client' => null,
    'telephone_client' => null,
    'addresse'=>null,
    'montant'=>null,
    'created_at' => null,
    'updated_at' => null,
    'deleted_at' => null,
  ];

  protected $datamap = [];

  public function __construct(array $data = null){
    parent::__construct($data);

  }









}
