<?php
namespace App\Models;
use CodeIgniter\Model;

class PvRestaurationModel extends Model{
  protected $table = 'g_interne_pv_restaure';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id','depots_id_dest','qte_restaure','date_restaurer','articles_id','qte_perdue','pv_en_kg','magaz_dest_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'date_restaurer' => 'required|valid_date[Y-m-d]',
    'depots_id_dest' => 'required|checkingForeignKeyExist[st_depots,id]',
    'articles_id' => 'required|checkingForeignKeyExist[g_articles,id]',
    'users_id'=>'required|checkingForeignKeyExist[g_users,id]',
    'qte_restaure' => 'required|greater_than[0]',
    'magaz_dest_id' =>'required|checkingForeignKeyExist[g_users,id]'

  ];
	protected $validationMessages = [
    'depots_id_dest'=>[
      'required' => 'Le depôt est obligatoire',
      'checkingForeignKeyExist'=>'Le depôt choisit n\'existe pas'
    ],
    'magaz_dest_id'=>[
      'required' => 'Le magasinier destination est obligatoire',
      'checkingForeignKeyExist'=>'Le magasinier choisit n\'existe pas'
    ],
    'date_restaurer'=>[
      'required' => 'La date de restauration est obligatoire',
      'valid_date'=>'Le format de la date est incorect'
    ],
    'users_id' => [
      'required' => 'L\'utilisateur est obligatoire',
      'checkingForeignKeyExist' => 'cet utilisateur n\'existe pas'
    ],
    'qte_restaure'=>[
      'required' => 'La quantité restaurée est obligatoire',
      'greater_than' => 'La quantité restaurée doit être superieur à 0'
    ],
    'articles_id'=>[
      'required' => 'L\'ID article est obligatoire',
      'checkingForeignKeyExist' => 'L\'article choisit est invalide'
    ],
  ];
  protected $returnType ='App\Entities\PvRestaurationEntity';


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
