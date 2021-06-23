<?php
namespace App\Models;
use CodeIgniter\Model;

class ApprovisionnementsInterDepotModel extends Model{
  protected $table = 'g_interne_approvisionnement_inter_depot';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['date_approvisionnement','depots_id_source','depots_id_dest','users_id','user_id_valid','status_operation'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'date_approvisionnement' => 'required|valid_date[Y-m-d]',
    'depots_id_source' => 'required|checkingForeignKeyExist[st_depots,id]',
    'depots_id_dest' => 'required|checkingForeignKeyExist[st_depots,id]',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]',
  ];
	protected $validationMessages = [
    'depots_id_source'=>[
      'required' => 'Le depôt source est obligatoire',
      'checkingForeignKeyExist'=>'Le depôt choisit n\'existe pas'
    ],
    'depots_id_dest'=>[
      'required' => 'Le depôt destination est obligatoire',
      'checkingForeignKeyExist'=>'Le depôt choisit n\'existe pas'
    ],
    'date_approvisionnement'=>[
      'required' => 'La date d\'approvisionnement est obligatoire',
      'valid_date'=>'Le format de la date est incorect'
    ]
  ];
  protected $returnType ='App\Entities\ApprovisionnementsInterDepotEntity';


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
