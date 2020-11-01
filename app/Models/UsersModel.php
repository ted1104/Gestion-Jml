<?php
namespace App\Models;
use CodeIgniter\Model;
class UsersModel extends Model{
  protected $table = 'o_users';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['username','password','name','lastname'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'username' => 'required|min_length[4]|is_unique[o_users.username]',
    'password' => 'required',
    'name' => 'required',
    'lastname' => 'required'
  ];
	protected $validationMessages = [
    'username'=>[
              'required' => 'Ce champs est obligatoire',
              'min_length' => 'Le nom d\'utilisateur doit avoir au minimu 4 caractères'
            ],

  ];
  protected $returnType ='App\Entities\UsersEntity';


  public function authLogin($user){
    $userData = $this->getWhere([
      'username' => $user['username']
    ]);
    if($userData->resultID->num_rows > 0){
      $userData = $userData->getRow();
      $verify = password_verify($user['password'], $userData->password);
      if($verify){
        return [
          'id'=>$userData->id,
          'username' => $userData->username,
          'name' => $userData->name,
          'lastname' => $userData->lastname,
          'isLoggedIn' => true
        ];
      }
    }
    return false;
  }


// LES TRANSACTIONS
  public function begTrans(){
    $this->db->transBegin();
  }
  public function RollbackTrans(){
    $this->db->transRollback();
  }
  public function commitTrans(){
    $this->db->transCommit();
  }
}
