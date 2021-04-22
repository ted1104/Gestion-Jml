<?php
namespace App\Models;
use CodeIgniter\Model;

class AretirerModel extends Model{
  protected $table = 'g_interne_a_retirer';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['vente_detail_id','qte_restante','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'vente_detail_id' => 'required',
    'qte_restante' => 'required',
    'users_id' => 'required',
  ];
  protected $validationMessages = [
    'vente_detail_id'=>['required' => 'Le champ vente_detail_id est obligatoire',],
    'qte_restante'=>['required' => 'Le champ qte_restante est obligatoire'],
    'users_id'=>['required' => 'Le champ users_id est obligatoire'],
  ];
  protected $returnType ='App\Entities\AretirerEntity';
}
