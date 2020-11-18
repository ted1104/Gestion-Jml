<?php
namespace App\Models;
use CodeIgniter\Model;

class CommandesStatusHistoriqueModel extends Model{
  protected $table = 'g_interne_vente_historique_status';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['vente_id','status_vente_id','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'vente_id' => 'required',
    'status_vente_id' => 'required',
    'users_id' => 'required',
  ];
	protected $validationMessages = [
    'vente_id'=>[
      'required' => 'ID vente obligatoire',
    ],
    'status_vente_id'=>['required' => 'Le status vente est obligatoire'],
    'users_id'=>['required' => 'L\'utilisateur est obligatoire'],
  ];
  protected $returnType ='object';


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
