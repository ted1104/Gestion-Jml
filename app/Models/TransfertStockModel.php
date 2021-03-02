<?php
namespace App\Models;
use CodeIgniter\Model;

class TransfertStockModel extends Model{
  protected $table = 'g_interne_transfert_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['date_transfert','users_id_source','users_id_dest','users_id','status_operation'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'date_transfert' => 'required|valid_date[Y-m-d]',
    'users_id_source' => 'required|checkingForeignKeyExist[g_users,id]',
    'users_id_dest' => 'required|checkingForeignKeyExist[g_users,id]',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]',
  ];
	protected $validationMessages = [
    'users_id_source'=>[
      'required' => 'L\'utilisateur source est obligatoire',
      'checkingForeignKeyExist'=>'L\'utilisateur choisit n\'existe pas'
    ],
    'users_id_dest'=>[
      'required' => 'L\'utilisateur destinatiton est obligatoire',
      'checkingForeignKeyExist'=>'L\'utilisateur choisit n\'existe pas'
    ],
    'date_approvisionnement'=>[
      'required' => 'La date d\'approvisionnement est obligatoire',
      'valid_date'=>'Le format de la date est incorect'
    ]
  ];
  protected $returnType ='App\Entities\TransfertStockEntity';


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
