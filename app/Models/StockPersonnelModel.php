<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\ArticlesModel;

class StockPersonnelModel extends Model{
  protected $table = 'g_interne_personnel_stock';
  protected $DBGroup = 'default';
  protected $primaryKey = 'id';
  protected $allowedFields = ['articles_id','users_id','qte_stock'];
  protected $useTimestamps = true;
  protected $validationRules = [
    'articles_id' => 'required',
    'users_id' => 'required',
    'qte_stock' => 'required',
  ];
  protected $validationMessages = [
    'articles_id'=>['required' => 'Le champ articles_id est obligatoire',],
    'depot_id'=>['required' => 'Le champ utilisateur(Magazinier) est obligatoire'],
    'qte_stock'=>['required' => 'Le champ qte_stock est obligatoire'],
  ];
  protected $returnType ='App\Entities\StockPersonnelEntity';
  protected $articleModel = null;

  public function insertArticleInStockPersonnelIfNotExit($idUser){
      $this->articleModel = new ArticlesModel();
      if(!$this->Where('users_id',$idUser)->find()){
        $allArticle = $this->articleModel->findAll();
        foreach ($allArticle as $key => $value) {
          $data = [
            'articles_id' =>$value->id,
            'users_id' =>$idUser,
            'qte_stock' => 0
          ];
          $insert = $this->insert($data);
        }
        return true;
      }
      return true;

  }

  public function updateAddQtePersonnel($idUser, $idArticle, $newQteToUpdate){
    $searchLine = $this->Where('articles_id', $idArticle)->Where('users_id',$idUser)->find();
    $oldQte = $searchLine[0]->qte_stock + $newQteToUpdate;
    if($searchLine){
      $update = $this->update($searchLine[0]->id, ['qte_stock'=>$oldQte]);
      if($update){
        return true;
      }
    }
    return false;

  }
}
