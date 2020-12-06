<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\CaisseModel;

class UsersModel extends Model{
  protected $table = 'g_users';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nom','prenom','sexe','dob','roles_id','depot_id','date_debut_service','date_fin_service','is_main','tel','photo'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'nom' => 'required',
    'prenom' => 'required',
    'sexe' => 'required',
    'roles_id' => 'required|checkingForeignKeyExist[st_roles,id]',
    'depot_id' => 'required|checkingForeignKeyExist[st_depots,id]',
    'date_debut_service' => 'required'
  ];
	protected $validationMessages = [
    'nom'=>['required' => 'Le nom est obligatoire'],
    'prenom'=>['required' => 'Le prenom est obligatoire'],
    'sexe'=>['required' => 'Le sexe est obligatoire'],
    'depot_id'=>[
      'required' => 'Le lieu d\'affectation est obligatoire',
      'checkingForeignKeyExist' => 'Le lieu d\'affectation selectionné n\'existe pas'
    ],
    'roles_id'=>[
      'required' => 'Le profile est obligatoire',
      'checkingForeignKeyExist' => 'Le profile selectionné n\'existe pas'
    ],
    'date_debut_service'=>['required' => 'La date du debut de service est obligatoire'],

  ];
  protected $returnType ='App\Entities\UsersEntity';
  protected $caisseModel = null;

  public function getSommeAllCaissier(){
    $this->caisseModel = new CaisseModel();
    $data = $this->caisseModel->selectSum('montant')->find();
    return round($data[0]->montant,2);
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
