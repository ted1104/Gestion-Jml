<?php
namespace App\Models;
use CodeIgniter\Model;


class DroitAccessModel extends Model{
  protected $table = 'g_droit_access';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['users_id','g_pv','g_achat_partiels','g_systeme','g_systeme_cloture_stock','g_systeme_cloture_caisse','g_systeme_operation_compte'];
  protected $useTimestamps = false;
  protected $validationRules = [
    'users_id' => 'required|integer'
  ];
  protected $validationMessages = [];
  protected $returnType ='object';

}
