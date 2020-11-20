<?php
namespace App\Models;
use CodeIgniter\Model;

class UsersAuthModel extends Model{
  protected $table = 'g_users_auth';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['username','password_main','password_op','users_id','status_users_id'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'username' => 'required|is_unique[g_users_auth.username]',
    'password_main' => 'required|min_length[8]',
    'password_op' => 'required|min_length[8]',
    'users_id' => 'required',
    'status_users_id' => 'required'
  ];
	protected $validationMessages = [
    'username'=>[
      'required' => 'Le nom utilisateur est obligatoire',
      'is_unique' => 'Ce nom d\'utilisateur existe déjà'
    ],
    'password_main'=>['required' => 'Le mot de passe principal est obligatoire'],
    'password_op'=>['required' => 'Le mot de passe des opérations est obligatoire'],
    'users_id'=>['required' => 'Le user_id est obligatoire'],
    'role_id'=>['required' => 'Le profile est obligatoire'],
    'status_users_id'=>['required' => 'La status_users_id obligatoire'],

  ];
  protected $returnType ='App\Entities\UsersAuthEntity';

  public function authLogin($user){
    $userData = $this->Where('username',$user['username'])->findAll();
    if(count($userData) > 0){
      $verify = password_verify($user['password_main'], $userData[0]->password_main);
      if($verify){
        return [
          'info'=> $userData[0]->users_id,
          'isLoggedIn' => true
        ];
      }
    }
    return false;
  }

  public function authPasswordOperation($iduser,$password){
    $userData = $this->Where('users_id',$iduser)->findAll();
    if(count($userData) > 0){
      $verify = password_verify($password, $userData[0]->password_op);
      if($verify){
        return true;
      }
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