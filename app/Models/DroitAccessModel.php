<?php
namespace App\Models;
use CodeIgniter\Model;


class DroitAccessModel extends Model{
  protected $table = 'g_droit_access';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id','g_pv','g_achat_partiels'];
  protected $useTimestamps = false;
  protected $validationRules = [
    'users_id' => 'required|integer'
  ];
  protected $validationMessages = [];
  protected $returnType ='object';

}
