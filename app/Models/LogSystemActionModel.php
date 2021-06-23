<?php
namespace App\Models;
use CodeIgniter\Model;


class LogSystemActionModel extends Model{
  protected $table = 'g_log_system_action';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['name','description', 'severite'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'action_id' => 'required'
  ];
  protected $validationMessages = [];
  protected $returnType ='object';

  // public function addLogSys($users, $action, $notice =null){
  //   //CREATE LOG SYSTEM
  //   $dataLog = [
  //     "users_id" =>$users == 0 ? null : $users,
  //     "action_id" =>$action,
  //     "notice" =>$notice
  //   ];
  //   $insert = $this->insert($dataLog);
  //   if(!$insert){
  //       return false;
  //   }
  //
  //   return true;
  // }


  // public function checkingIfAnotherDepotCentralExit($isCentral){
  //   if($isCentral==1){
  //     if($this->Where('is_central',$isCentral)->find()){
  //       return false;
  //     }
  //   }
  //   return true;
  // }

}
