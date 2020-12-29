<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ArticlesEntity;
use App\Models\ArticlesPrixModel;
use App\Models\ArticlesPrixHistoriqueModel;
use App\Models\StockModel;
use App\Models\StDepotModel;

class Articles extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ArticlesModel';
  protected $articlesPrixModel = null;
  protected $articlesPrixHistoriqueModel = null;
  protected $stockModel = null;
  protected $depotModel = null;


  public function __construct(){
    helper(['global']);
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->articlesPrixHistoriqueModel = new ArticlesPrixHistoriqueModel();
    $this->stockModel = new StockModel();
    $this->depotModel = new StDepotModel();
  }
  public function articles_get(){
    $data = $this->model->findAll();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function articles_create(){
    $this->model->beginTrans();
    $data = new ArticlesEntity($this->request->getPost());
    $insertData = $this->model->insert($data);
    if(!$insertData){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      $depots = $this->depotModel->findAll();
      foreach ($depots as $key => $value) {
        $datStock = [
          'articles_id'=>$insertData,
          'depot_id'=>$value->id,
          'qte_stock'=>0
        ];
        if(!$this->stockModel->insert($datStock)){
          $this->model->RollbackTrans();
        }
      }
      $status = 200;
      $message = [
        'success' => 'Enregistrement de l\'article reussi avec succès',
        'errors' => null
      ];
      $data = 'null';
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function articles_set_price(){
    $this->articlesPrixModel->beginTrans();
    $data = $this->request->getPost();
    if(!$this->articlesPrixModel->getWhere(['articles_id'=>$data['articles_id'],'type_prix'=>$data['type_prix']])->getRow()){
        $insertData = $this->articlesPrixModel->insert($data);
        if(!$insertData){
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>$this->articlesPrixModel->errors()
          ];
          $data = null;
        }else{
          $dataHistorique =[
          'prix_id'=>$this->articlesPrixModel->insertID(),
          'type_prix'=>$this->request->getPost('type_prix'),
          'prix_unitaire'=>$this->request->getPost('prix_unitaire'),
          'qte_decideur'=>$this->request->getPost('qte_decideur'),
          'users_id'=>$this->request->getPost('users_id'),
          ];
          if(!$this->articlesPrixHistoriqueModel->insert($dataHistorique)){
            $this->articlesPrixModel->RollbackTrans();
            $status = 400;
            $message = [
              'success' =>null,
              'errors'=>$this->articlesPrixHistoriqueModel->errors()
            ];
            $data = null;
          }else{
            $status = 200;
            $message = [
              'success' => 'Enregistrement reussi',
              'errors' => null
            ];
            $data = 'null';
          }

        }
    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>'Cet article possède déjà un prix configuré'
      ];
      $data = null;
    }
    $this->articlesPrixModel->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function article_search_data_commande($codeArticle,$qte,$depotid,$isFaveur){
     $codeArt = $codeArticle;
     $Qte = $qte;
     $depot = $depotid;
     $isFaveur = $isFaveur;
     $QteToOfferFaveur = 2;
     $data = $this->model->Where('code_article',$codeArt)->find();
     if($data){
       //CHECK IF DEPOT HAS THIS QUANTIY
       $condition =[
         'depot_id'=>$depot,
         'articles_id'=>$data[0]->id
       ];
       //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
       $initqte = $this->stockModel->getWhere($condition)->getRow();
       if(!$initqte){
         $status = 400;
         $message = [
           'success' =>null,
           'errors'=>'Impossible de trouver cet article dans le dépot central veuillez contacter l\'administrateur du système'
         ];
         $data = null;
       }else{
         if($Qte <= $initqte->qte_stock_virtuel){
         // return $this->respond([$initqte->qte_stock]);
         if($data[0]->logic_detail_data && count($data[0]->logic_detail_data) > 1){
           $grosprix = null;
           $detailUnit = null;
           $qteDetail = null;
               foreach ($data[0]->logic_detail_data as $key => $value) {
                  if($value->type_prix==1){
                    $grosprix = $value->prix_unitaire;
                    $qteDetail = $value->qte_decideur;
                  }
                  if($value->type_prix==2){
                    $detailUnit = $value->prix_unitaire;
                    $qteDetail = $value->qte_decideur;
                  }
               }
                 $PU = null;
                 $message = null;
                 if($Qte <= $qteDetail){
                   $PU = $detailUnit;
                   $type = 'En détail';
                   $t_id = 2;
                  }
                 if($qteDetail < $Qte){
                   $PU = $grosprix;
                   $type = 'En Gros';
                   $t_id = 1;
                 }
                 //CHECK IF FAVEUR THEN APPLY GROS PRICE
                 if($isFaveur == 1 and $Qte <= $QteToOfferFaveur){
                   $PU = $grosprix;
                   $type = 'En Gros';
                   $t_id = 1;
                   $message = "avec une reduction";
                 }
                 $status = 200;
                 $message = [
                   'success' =>'Bien ajouté '.$message,
                   'errors'=> null
                 ];

                 $data = [
                   'id'=>$data[0]->id,
                   'code' => $codeArt,
                   'nom_article' => $data[0]->nom_article,
                   'qte' => $Qte,
                   'prix_unit' =>$PU,
                   'type_prix' => $type,
                   'type_id' =>$t_id
                 ];
                 //ERROR SI FAVEUR MAIS QUANTITE N'EST PAS LA BONNE
                 if($isFaveur == 1 and $Qte > $QteToOfferFaveur){
                   $status = 400;
                   $message = [
                     'success' =>null,
                     'errors'=>'En activant Faveur sur un article la quantité ne doit pas depasser 2'
                   ];
                   $data = null;
                 }

         }else{
           $status = 400;
           $message = [
             'success' =>null,
             'errors'=>'Cet article ne possède pas toutes les configurations des prix! Veuillez svp contacter l\'administrateur ou le manager'
           ];
           $data = null;
         }
       }else{
         $status = 400;
         $message = [
           'success' =>null,
           'errors'=>'Ce dépôt ne possède pas cette quantité d\'article en stock'
         ];
         $data = null;
       }
     }
     }else{
       $status = 400;
       $message = [
         'success' =>null,
         'errors'=>'Aucun Article trouvé avec ce code'
       ];
       $data = null;
     }

     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);

  }
  public function article_search_by_code($code){
    $data = $this->model->Where('code_article',$code)->find();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function article_update_price(){
    $idarticle = $this->request->getPost('articles_id');
    $newPrice = $this->request->getPost('prix_unitaire');
    $type = $this->request->getPost('type_prix');
    $newQte = $this->request->getPost('qte_decideur');
    if(is_numeric ($newPrice) && is_numeric($newQte)){
      $condition =[
        'articles_id'=>$idarticle,
        'type_prix' =>$type,
      ];
      $data =[
        'prix_unitaire'=>$newPrice,
        'qte_decideur'=>$newQte
      ];
      $info = $this->articlesPrixModel->Where($condition)->find();
      if($this->articlesPrixModel->update($info[0]->id,$data)){

        $dataHistorique =[
          'prix_id'=>$info[0]->id,
          'type_prix'=>$type,
          'prix_unitaire'=>$newPrice,
          'qte_decideur'=>$newQte,
          'users_id'=>$this->request->getPost('users_id'),
        ];
        if(!$this->articlesPrixHistoriqueModel->insert($dataHistorique)){
          // $this->articlesPrixModel->RollbackTrans();
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>$this->articlesPrixHistoriqueModel->errors()
          ];
          $data = null;
        }else{
          $status = 400;
          $message = [
            'success' =>'Modification avec succès',
            'errors'=>null
          ];
          $data = null;
        }
      }

    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>['Le montant ou la quantité est invalide']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);
  }
  public function article_search_for_appro_inter_depot($codeArticle,$qte,$depotid){
    $codeArt = $codeArticle;
    $Qte = $qte;
    $depot = $depotid;
    $data = $this->model->Where('code_article',$codeArt)->find();
    if($data){
      //CHECK IF DEPOT HAS THIS QUANTIY
      $condition =[
        'depot_id'=>$depot,
        'articles_id'=>$data[0]->id
      ];
      //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
      $initqte = $this->stockModel->getWhere($condition)->getRow();
      if(!$initqte){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'Impossible de trouver cet article dans le dépôt veuillez contacter l\'administrateur du système'
        ];
        $data = null;
      }else{
        if($Qte <= $initqte->qte_stock_virtuel and $Qte <= $initqte->qte_stock){
        // return $this->respond([$initqte->qte_stock]);
            $status = 200;
            $message = [
              'success' =>'Bien ajouté ',
              'errors'=> null
            ];
            $data = [
              'id'=>$data[0]->id,
              'code' => $codeArt,
              'nom_article' => $data[0]->nom_article,
              'qte' => $Qte,
            ];

      }else{
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'La quantité à approvisionner doit être inférieure ou égale à votre quantité physique et réelle'
        ];
        $data = null;
      }
    }
    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>'Aucun Article trouvé avec ce code'
      ];
      $data = null;
    }

    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function multitest(){
    print_r($this->request->getPost());

  }
}
