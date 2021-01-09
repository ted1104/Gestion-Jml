<?php
namespace App\Models;
use CodeIgniter\Model;

class ArticlesModel extends Model{
  protected $table = 'g_articles';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['code_article','nom_article','date_vente','description','nombre_piece','users_id','logic_detail_data'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'code_article' => 'required|is_unique[g_articles.code_article]',
    'nom_article' => 'required',
    'description' => 'required',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]'
  ];
	protected $validationMessages = [
    'code_article'=>[
      'required' => 'Le code de l\'article est obligatoire',
      'is_unique' => 'Le code renseigné existe déjà'
    ],
    'nom_article'=>['required' => 'Le nom de l\'article est obligatoire'],
    'description'=>['required' => 'La descrition est obligatoire'],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ]

  ];
  protected $returnType ='App\Entities\ArticlesEntity';


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
