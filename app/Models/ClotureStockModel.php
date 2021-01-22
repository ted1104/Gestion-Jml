<?php
namespace App\Models;
use CodeIgniter\Model;


class ClotureStockModel extends Model{
  protected $table = 'g_interne_cloture_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','depot_id','qte_stock','date_cloture'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required',
    'depot_id' => 'required',
    'qte_stock' => 'required',
    'date_cloture' => 'required'
  ];
  protected $validationMessages = [
    'articles_id'=>['required' => 'Le champ articles_id est obligatoire',],
    'depot_id'=>['required' => 'Le champ depot_id est obligatoire'],
    'qte_stock'=>['required' => 'Le champ qte_stock est obligatoire'],
    'date_cloture' => ['required' => 'La date est obligatoire']
  ];
  protected $returnType ='App\Entities\ClotureStockEntity';
}
