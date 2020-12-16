<?php
namespace App\Models;
use CodeIgniter\Model;

class ArticlesPrixModel extends Model{
  protected $table = 'g_articles_prix';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','type_prix','prix_unitaire','qte_decideur','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'type_prix' => 'required|checkingForeignKeyExist[st_type_prix,id]',
    'prix_unitaire' => 'required|numeric',
    'qte_decideur' => 'required|integer',
    'users_id' => 'required|checkingForeignKeyExist[g_users,id]'
  ];
	protected $validationMessages = [
    'articles_id'=>[
      'required' => 'L\'article est obligatoire',
      'checkingForeignKeyExist' => 'Cet article n\'existe pas',
    ],
    'type_prix'=>[
      'required' => 'Le type_prix est obligatoire',
      'checkingForeignKeyExist' => 'Ce type de prix n\'existe pas'
    ],
    'prix_unitaire'=>[
      'required' => 'Le PU est obligatoire',
      'numeric' => 'Le PU est invalide'
    ],
    'users_id'=>[
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'Cet utilisateur n\'existe pas'
    ],
    'qte_decideur'=>[
      'required' => 'La Quantité determinante est obligatoire',
      'integer' => 'La Quantité decideur est invalide'
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
