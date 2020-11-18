<?php
namespace App\Models;
use CodeIgniter\Model;

class ApprovisionnementsModel extends Model{
  protected $table = 'g_interne_approvisionnement';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['date_approvisionnement','depots_id','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'date_approvisionnement' => 'required|valid_date[Y-m-d]',
    'depots_id' => 'required|checkingForeignKeyExist[st_depots,id]',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]'
  ];
	protected $validationMessages = [
    'depots_id'=>[
      'required' => 'Le depôt est obligatoire',
      'checkingForeignKeyExist'=>'Le depôt choisit n\'existe pas'
    ],
    'date_approvisionnement'=>[
      'required' => 'La date d\'approvisionnement est obligatoire',
      'valid_date'=>'Le format de la date est incorect'
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ]

  ];
  protected $returnType ='App\Entities\ApprovisionnementsEntity';


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
