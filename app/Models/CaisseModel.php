<?php
namespace App\Models;
use CodeIgniter\Model;

class CaisseModel extends Model{
  protected $table = 'g_interne_caisse';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['montant','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'montant' => 'required',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]'
  ];
	protected $validationMessages = [
    'montant'=>[
      'required' => 'Le montant est obligatoire',
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ]

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
