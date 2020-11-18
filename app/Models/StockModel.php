<?php
namespace App\Models;
use CodeIgniter\Model;

class StockModel extends Model{
  protected $table = 'g_interne_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','depot_id','qte_stock'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required',
    'depot_id' => 'required',
    'qte_stock' => 'required',
  ];
  protected $validationMessages = [
    'articles_id'=>['required' => 'Le champ articles_id est obligatoire',],
    'depot_id'=>['required' => 'Le champ depot_id est obligatoire'],
    'qte_stock'=>['required' => 'Le champ qte_stock est obligatoire'],
  ];
  protected $returnType ='App\Entities\StockEntity';
}
