<?php
namespace App\Models;
use CodeIgniter\Model;

class EncaissementExterneModel extends Model{
  protected $table = 'g_interne_encaissement_externe';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['motif','users_id','montant_encaissement','date_encaissement'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'motif' => 'required',
    'users_id' => 'required|checkingForeignKeyExist[g_users,id]',
    'montant_encaissement' => 'required|greater_than[0]',
  ];
	protected $validationMessages = [
    'motif'=>[
      'required' => 'Le motif est obligatoire',
    ],
    'users_id'=>[
      'required' => 'Le users_id est obligatoire',
      'checkingForeignKeyExist' => 'L\'utilisateur est introuvable'
    ],
    'montant_encaissement'=>[
      'required' => 'Le montant encaissement est obligatoire',
      'greater_than' => 'Le montant doit être superieur à 0'
    ],

  ];
  protected $returnType ='App\Entities\EncaissementExterneEntity';


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
