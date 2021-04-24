<?php
namespace App\Models;
use CodeIgniter\Model;

class AretirerModel extends Model{
  protected $table = 'g_interne_a_retirer';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['vente_detail_id','qte_retirer','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'vente_detail_id' => 'required',
    'qte_retirer' => 'required',
    'users_id' => 'required',
  ];
  protected $validationMessages = [
    'vente_detail_id'=>['required' => 'Le champ vente_detail_id est obligatoire',],
    'qte_retirer'=>['required' => 'Le champ qte_retirer est obligatoire'],
    'users_id'=>['required' => 'Le champ users_id est obligatoire'],
  ];
  protected $returnType ='App\Entities\AretirerEntity';

  // LES TRANSACTIONS
  public function beginTrans(){
    $this->db->transBegin();
  }
  public function RollbackTrans(){
    $this->db->transRollback();
  }
  public function commitTrans(){
    $this->db->transCommit();
  }
}
