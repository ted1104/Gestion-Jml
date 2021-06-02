<?php
namespace App\Models;
use CodeIgniter\Model;

class StockModel extends Model{
  protected $table = 'g_interne_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','depot_id','qte_stock','qte_stock_virtuel'];
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


  public function updateQteReelleStockDepot($iddepot, $idArticle, $newQteToUpdate,$paramAction=1){
    $searchLine = $this->getWhere(['depot_id'=>$iddepot,'articles_id'=>$idArticle])->getRow();
    if($paramAction==1){
      $newQte = $searchLine->qte_stock + $newQteToUpdate;
    }else{
      // print_r($newQteToUpdate);
      // die();
      $newQte = $searchLine->qte_stock - $newQteToUpdate;
    }


    if($searchLine){
      $update = $this->update($searchLine->id, ['qte_stock'=>$newQte]);
      // $update = $this->set('qte_stock',$newQte)->Where('id',$searchLine->id)->update();
      if($update){
        return true;
      }
    }
    return false;
  }
}
