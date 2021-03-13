<?php
namespace App\Models;
use CodeIgniter\Model;

class StMotifDecaissementExterneModel extends Model{
  protected $table = 'st_motif_decaissement_externe';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['description','is_active'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'description' => 'required|is_unique[st_motif_decaissement_externe.description]',
  ];
  protected $validationMessages = [
    'description'=>[
      'required' => 'Le nom du type de la destination du decaissement externe est obligatoire',
      'is_unique' => 'ce nom du type la destination du decaissement externe renseigné existe déjà'],
  ];
  protected $returnType ='object';
}
