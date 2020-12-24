<?php
namespace App\Models;
use CodeIgniter\Model;

class CommandesDetailModel extends Model{
  protected $table = 'g_interne_vente_detail';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['vente_id','articles_id','qte_vendue','prix_unitaire','type_prix','is_negotiate','prix_negociation','is_faveur'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'vente_id' => 'required',
    'articles_id' => 'required',
    'qte_vendue' => 'required',
  ];
	protected $validationMessages = [
    'vente_id'=>[
      'required' => 'ID vente obligatoire',
    ],
    'articles_id'=>['required' => 'Le article est obligatoire'],
    'qte_vendue'=>['required' => 'La quantité est obligatoire'],
  ];
  protected $returnType ='App\Entities\CommandesDetailEntity';


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
