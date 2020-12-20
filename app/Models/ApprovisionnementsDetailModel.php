<?php
namespace App\Models;
use CodeIgniter\Model;

class ApprovisionnementsDetailModel extends Model{
  protected $table = 'g_interne_approvisionnement_detail';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['approvisionnement_id','articles_id','qte','qte_total','qte_pv'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'approvisionnement_id' => 'required|checkingForeignKeyExist[g_interne_approvisionnement,id]',
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'qte'=>'required|numeric',
    'qte_total' => 'required|numeric',
    'qte_pv' => 'required|numeric'
  ];
	protected $validationMessages = [
    'approvisionnement_id'=>[
      'required' => 'L\'approvisionnement est obligatoire',
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
    ],
    'qte_total' =>[
      'required' => 'La quantité totale est obligatoire',
      'numeric' => 'La quantité totale est invalide',
    ],
    'qte_pv' =>[
      'required' => 'La quantité PV est obligatoire',
      'numeric' => 'La quantité PV est invalide',
    ]

  ];
  protected $returnType ='App\Entities\ApprovisionnementsDetailEntity';



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
