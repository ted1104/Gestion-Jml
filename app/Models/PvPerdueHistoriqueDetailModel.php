<?php
namespace App\Models;
use CodeIgniter\Model;

class PvPerdueHistoriqueDetailModel extends Model{
  protected $table = 'g_interne_pv_perdue_historique_detail';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','qte_perdue','pv_historique_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'qte_perdue' => 'required|greater_than[0]',
    'pv_historique_id' => 'required|checkingForeignKeyExist[g_interne_pv_perdue_historique,id]'

  ];
	protected $validationMessages = [

    'magaz_source_id'=>[
      'required' => 'Le magasinier source est obligatoire',
      'checkingForeignKeyExist'=>'Le magasinier choisit n\'existe pas'
    ],
    'articles_id'=>[
      'required' => 'L\'ID article est obligatoire',
      'checkingForeignKeyExist' => 'L\'article choisit est invalide'
    ],
    'qte_perdue'=>[
      'required' => 'La quantité perdue est obligatoire',
      'greater_than' => 'La quantité perdue doit être superieure à 0'
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
