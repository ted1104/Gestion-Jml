<?php
namespace App\Models;
use CodeIgniter\Model;

class PvPerdueHistoriqueModel extends Model{
  protected $table = 'g_interne_pv_perdue_historique';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['depots_id','magaz_source_id','users_id','date_historique'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'depots_id' => 'required|checkingForeignKeyExist[st_depots,id]',
    'magaz_source_id' =>'required|checkingForeignKeyExist[g_users,id]',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]',
  ];
	protected $validationMessages = [
    'depots_id'=>[
      'required' => 'Le depôt est obligatoire',
      'checkingForeignKeyExist'=>'Le depôt choisit n\'existe pas'
    ],
    'magaz_source_id'=>[
      'required' => 'Le magasinier destination est obligatoire',
      'checkingForeignKeyExist'=>'Le magasinier choisit n\'existe pas'
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ],


  ];
  protected $returnType ='App\Entities\PvPerdueHistoriqueEntity';


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
