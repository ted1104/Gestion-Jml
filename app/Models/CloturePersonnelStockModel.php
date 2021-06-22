<?php
namespace App\Models;
use CodeIgniter\Model;


class CloturePersonnelStockModel extends Model{
  protected $table = 'g_interne_cloture_personnel_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','users_id','qte_stock','date_cloture'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required',
    'users_id' => 'required',
    'qte_stock' => 'required',
    'date_cloture' => 'required'
  ];
  protected $validationMessages = [
    'articles_id'=>['required' => 'Le champ articles_id est obligatoire',],
    'users_id'=>['required' => 'Le champ users_id est obligatoire'],
    'qte_stock'=>['required' => 'Le champ qte_stock est obligatoire'],
    'date_cloture' => ['required' => 'La date est obligatoire']
  ];
  protected $returnType ='App\Entities\CloturePersonnelStockEntity';
}
