<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Models\ArticlesModel;
use App\Models\UsersModel;

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
  protected $userModel = null;

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

  public function insertArticleInStockPersonnelIfNotExitWhenArticleCreated($idArticle){
      // $this->articleModel = new ArticlesModel();
      $this->userModel = new UsersModel();
      $allUsersMagazinier = $this->userModel->Where('roles_id',5)->findAll();
      foreach ($allUsersMagazinier as $users){
          $data = [
            'articles_id' =>$idArticle,
            'users_id' =>$users->id,
            'qte_stock' => 0
          ];
          $insert = $this->insert($data);
        // return true;
      }
      return true;

  }

  public function updateQtePersonnel($idUser, $idArticle, $newQteToUpdate,$paramAction=1){
    $searchLine = $this->Where('articles_id', $idArticle)->Where('users_id',$idUser)->find();
    if($paramAction==1){
      $newQte = $searchLine[0]->qte_stock + $newQteToUpdate;
    }else{
      $newQte = $searchLine[0]->qte_stock - $newQteToUpdate;
    }
    if($searchLine){
      $update = $this->update($searchLine[0]->id, ['qte_stock'=>$newQte]);
      if($update){
        return true;
      }
    }
    return false;
  }

  public function InjectStockPersonnelAllExisitingMagazinier(){
    $this->articleModel = new ArticlesModel();
    $this->userModel = new UsersModel();
    $allUsersMagazinier = $this->userModel->Where('roles_id',5)->findAll();
    $allArticle = $this->articleModel->findAll();
    foreach ($allUsersMagazinier as $users){
      foreach ($allArticle as $keyArt) {
        $data = [
          'articles_id' =>$keyArt->id,
          'users_id' =>$users->id,
          'qte_stock' => 0
        ];
        if(!$this->Where('users_id',$users->id)->Where('articles_id',$keyArt->id)->find()){
          $insert = $this->insert($data);
        }
      }
    }
    return true;
  }
}
