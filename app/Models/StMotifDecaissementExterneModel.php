<?php
namespace App\Models;
use CodeIgniter\Model;

class StMotifDecaissementExterneModel extends Model{
  protected $table = 'st_motif_decaissement_externe';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['description'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'description' => 'required|is_unique[st_motif_decaissement_externe.description]',
  ];
  protected $validationMessages = [
    'description'=>[
      'required' => 'Le nom de la destination du decaissement est obligatoire',
      'is_unique' => 'Le nom de la destination du decaissement externe du renseigné existe déjà'],
  ];
  protected $returnType ='object';
}
