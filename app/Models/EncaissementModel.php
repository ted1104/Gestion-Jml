<?php
namespace App\Models;
use CodeIgniter\Model;

class EncaissementModel extends Model{
  protected $table = 'g_interne_encaissement';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['vente_id','users_id','montant_encaissement','date_encaissement'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'vente_id' => 'required',
    'users_id' => 'required',
    'montant_encaissement' => 'required',
  ];
	protected $validationMessages = [
    'vente_id'=>[
      'required' => 'La vente_id est obligatoire',
    ],
    'users_id'=>['required' => 'Le users_id est obligatoire'],
    'montant_encaissement'=>[
      'required' => 'Le montant encaissement est obligatoire',
    ],
  
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
