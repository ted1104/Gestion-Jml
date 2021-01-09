<?php
namespace App\Models;
use CodeIgniter\Model;

class ArticlesConfigFaveurModel extends Model{
  protected $table = 'g_articles_config_prix_faveur';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','prix_id','qte_faveur','users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required',
    'prix_id' => 'required',
    'qte_faveur' => 'required',
    'users_id' => 'required',
  ];
	protected $validationMessages = [
    'articles_id'=>[
      'required' => 'L\'article est obligatoire',
    ],
    'prix_id'=>['required' => 'Le Type interval de prix est obligatoire'],
    'qte_faveur'=>['required' => 'La quantité faveur est obligatoire'],
    'users_id'=>['required' => 'L\'ID utilisateur est obligatoire'],


  ];
  protected $returnType ='App\Entities\ArticlesConfigFaveurEntity';


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
