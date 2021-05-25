<?php
namespace App\Models;
use CodeIgniter\Model;


class TransportPrixArticlesModel extends Model{
  protected $table = 'g_interne_transport_articles_prix';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['zone_id','article_id','prix'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'zone_id' => 'required|checkingForeignKeyExist[st_zone,id]',
    'article_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'prix' =>'required|greater_than[0]'
  ];
  protected $validationMessages = [
    'zone_id'=>[
              'required' => 'La zône est obligatoire',
              'checkingForeignKeyExist' => 'La zône choisie n\'existe pas'
            ],
    'article_id'=>[
              'required' => 'L\'article est obligatoire',
              'checkingForeignKeyExist' => 'L\'article choisi n\'existe pas'
            ],
    'prix'=>[
              'required' => 'Le prix est obligatoire',
              'greater_than' => 'Le prix doit être superieur à 0'
            ],
];
  protected $returnType ='App\Entities\TransportPrixArticlesEntity';


  public function checkingIfConfigExist($zone, $article){
    if($this->Where('zone_id', $zone)->Where('article_id', $article)->find()){
      return true;
    }
    return false;

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
