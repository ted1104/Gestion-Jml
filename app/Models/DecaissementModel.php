<?php
namespace App\Models;
use CodeIgniter\Model;

class DecaissementModel extends Model{
  protected $table = 'g_interne_decaissement';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id_from','users_id_dest','montant','date_decaissement','status_operation','note'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'users_id_from' => 'required|checkingForeignKeyExist[g_users,id]',
    'users_id_dest' => 'required|checkingForeignKeyExist[g_users,id]',
    'montant' => 'required',
  ];
	protected $validationMessages = [
    'users_id_from'=>[
      'required' => 'L\'utilisateur source est obligatoire',
      'checkingForeignKeyExist' => 'L\'utilisateur source choisit n\'existe pas'
    ],
    'users_id_dest'=>[
      'required' => 'Le caissier principal est obligatoire',
      'checkingForeignKeyExist' => 'Le caissier principal choisit n\'existe pas'
    ],
    'montant'=>[
      'required' => 'Le montant a decaissé est obligatoire',
    ],

  ];
  protected $returnType ='App\Entities\DecaissementEntity';


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
