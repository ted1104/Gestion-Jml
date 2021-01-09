<?php
namespace App\Models;
use CodeIgniter\Model;

class ArticlesPrixModel extends Model{
  protected $table = 'g_articles_prix';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','prix_unitaire','qte_decideur_min','qte_decideur_max','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'prix_unitaire' => 'required|numeric',
    'qte_decideur_min' => 'required|integer',
    'qte_decideur_max' => 'required|integer',
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
    'qte_decideur_min'=>[
      'required' => 'La Quantité minimum',
      'integer' => 'La Quantité minimum est invalide'
    ],
    'qte_decideur_max'=>[
      'required' => 'La Quantité max',
      'integer' => 'La Quantité max est invalide'
    ],

  ];
  protected $returnType ='object';

  public function checkIfAnotherConfigExistWithSameParam($idArticle,$qteMin,$qteMax){
    $lastConfigPrice = $this->Where('articles_id', $idArticle)->orderBy('id','DESC')->first();
    $response = false;
    if($lastConfigPrice){
      $vMin = $lastConfigPrice->qte_decideur_min;//1 = 15
      $vMax = $lastConfigPrice->qte_decideur_max;//15 = 20
      if($vMin < $qteMin && $vMax <= $qteMin){
        $response = true;
      }
    }else{
      $response = true;
    }
    return $response;

  }

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
