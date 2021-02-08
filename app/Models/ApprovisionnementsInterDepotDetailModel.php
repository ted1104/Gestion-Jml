<?php
namespace App\Models;
use CodeIgniter\Model;

class ApprovisionnementsInterDepotDetailModel extends Model{
  protected $table = 'g_interne_approvisionnement_inter_depot_detail';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['approvisionnement_id','articles_id','qte','is_validate'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'approvisionnement_id' => 'required|checkingForeignKeyExist[g_interne_approvisionnement_inter_depot,id]',
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'qte'=>'required|numeric'
  ];
	protected $validationMessages = [
    'approvisionnement_id'=>[
      'required' => 'L\'approvisionnement ID est obligatoire',
      'checkingForeignKeyExist' => 'Cet ID approvisionnement n existe pas'
    ],
    'articles_id'=>[
      'required' => 'L\' ID article est obligatoire',
      'checkingForeignKeyExist'=>'L\'ID article n\'existe pas'
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ],
    'qte' =>[
      'required' => 'La quantité est obligatoire',
      'numeric' => 'La quantité est invalide',
    ]
  ];
  protected $returnType ='App\Entities\ApprovisionnementsInterDepotDetailEntity';



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
