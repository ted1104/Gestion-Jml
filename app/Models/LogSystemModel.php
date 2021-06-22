<?php
namespace App\Models;
use CodeIgniter\Model;


class LogSystemModel extends Model{
  protected $table = 'g_log_system';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id','action_id', 'notice'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'action_id' => 'required'
  ];
  protected $validationMessages = [
    'action_id'=>[
              'required' => 'L\'action ID est obligatoire',
            ],

];
  protected $returnType ='App\Entities\LogSystemEntity';

  public function addLogSys($users, $action, $notice =null){
    //CREATE LOG SYSTEM
    $dataLog = [
      "users_id" =>$users,
      "action_id" =>$action,
      "notice" =>$notice
    ];
    $insert = $this->insert($dataLog);
    if(!$insert){
        return false;
    }

    return true;
  }


  // public function checkingIfAnotherDepotCentralExit($isCentral){
  //   if($isCentral==1){
  //     if($this->Where('is_central',$isCentral)->find()){
  //       return false;
  //     }
  //   }
  //   return true;
  // }

}
