<?php
namespace App\Models;
use CodeIgniter\Model;

class ArticlesPrixHistoriqueModel extends Model{
  protected $table = 'g_articles_prix_historique';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['prix_id','type_prix','prix_unitaire','qte_decideur','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'prix_id' => 'required',
    'type_prix' => 'required',
    'prix_unitaire' => 'required',
  ];
	protected $validationMessages = [
    'prix_id'=>[
      'required' => 'La ligne prix doit existe',
    ],
    'type_prix'=>['required' => 'Le type_prix est obligatoire'],
    'description'=>['required' => 'La Quantité determinante est obligatoire'],

  ];
  protected $returnType ='Object';


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
