<?php
namespace App\Models;
use CodeIgniter\Model;

class DecaissementExterneModel extends Model{
  protected $table = 'g_interne_decaissement_externe';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id_from','destination','montant','date_decaissement','note'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'users_id_from' => 'required|checkingForeignKeyExist[g_users,id]',
    'destination' => 'required',
    'montant' => 'required|greater_than[0]',
    'note'=> 'required'
  ];
	protected $validationMessages = [
    'users_id_from'=>[
      'required' => 'L\'utilisateur source est obligatoire',
      'checkingForeignKeyExist' => 'L\'utilisateur source choisit n\'existe pas'
    ],
    'destination'=>[
      'required' => 'La destination est obligatoire',
    ],
    'montant'=>[
      'required' => 'Le montant a decaissé est obligatoire',
      'greater_than' => 'Le montant doit être superieur à 0'
    ],
    'note'=>[
      'required' => 'La note est obligatoire',
    ],

  ];
  protected $returnType ='App\Entities\DecaissementExterneEntity';


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
