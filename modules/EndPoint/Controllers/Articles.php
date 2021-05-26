<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ArticlesEntity;
use App\Models\ArticlesPrixModel;
use App\Models\ArticlesPrixHistoriqueModel;
use App\Models\StockModel;
use App\Models\StDepotModel;
use App\Models\ArticlesConfigFaveurModel;
use App\Models\StockPersonnelModel;
use App\Models\TransportPrixArticlesModel;
use App\Entities\TransportPrixArticlesEntity;

class Articles extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ArticlesModel';
  protected $articlesPrixModel = null;
  protected $articlesPrixHistoriqueModel = null;
  protected $stockModel = null;
  protected $depotModel = null;
  protected $articlesConfigFaveurModel = null;
  protected $stockPersonnelModel = null;
  protected $transportPrixArticlesModel = null;


  public function __construct(){
    helper(['global']);
    $this->articlesPrixModel = new ArticlesPrixModel();
    $this->articlesPrixHistoriqueModel = new ArticlesPrixHistoriqueModel();
    $this->stockModel = new StockModel();
    $this->depotModel = new StDepotModel();
    $this->articlesConfigFaveurModel = new ArticlesConfigFaveurModel();
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->transportPrixArticlesModel = new TransportPrixArticlesModel();
  }
  public function articles_get($limit, $offset){
    $data = $this->model->findAll($limit, $offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->findAll())
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
      //create stock personnel when created an article
      if($this->stockPersonnelModel->insertArticleInStockPersonnelIfNotExitWhenArticleCreated($insertData)){
        $status = 200;
        $message = [
          'success' => 'Enregistrement de l\'article reussi avec succès',
          'errors' => null
        ];
        $data = 'null';
      }else{
        $status = 200;
        $message = [
          'success' => null,
          'errors' => 'Echec d\'enregistrement'
        ];
        $data = 'null';
      }

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

    if($this->request->getPost('qte_decideur_min') < $this->request->getPost('qte_decideur_max')){
    if($this->articlesPrixModel->checkIfAnotherConfigExistWithSameParam($this->request->getPost('articles_id'),$this->request->getPost('qte_decideur_min'),$this->request->getPost('qte_decideur_max'))){
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
            'prix_unitaire'=>$this->request->getPost('prix_unitaire'),
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
                'success' => 'Le prix a été enregistré avec succès',
                'errors' => null
              ];
              $data = 'null';
            }
          }
        }else{
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>['Cet article possède déjà un prix configuré à cet interval']
          ];
          $data = null;
        }
    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>['La quantité min doit être strictement inférieure à la quantité max']
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
     $qqte =  explode("sur",$qte);
     $depot = $depotid;
     $isFaveur = $isFaveur;
     $data = $this->model->Where('code_article',$codeArt)->find();
     if($data){
       //CONTROLE SUR LE QUANTITE ENVOYEE
       if(is_array($qqte) and count($qqte) > 1){
         if($qqte[0] < 1 OR $data[0]->nombre_piece <= $qqte[0]){
           if($data[0]->nombre_piece > 1){
             $message = [
               'success' =>null,
               'errors'=>'Quantité renseigné invalide !! Cet article ne contient que '.$data[0]->nombre_piece.' en détaillant! Veuillez verifier le nombre de pièce dans cet article'
             ];
           }else{
             $message = [
               'success' =>null,
               'errors'=>'Cet article ne peut pas être vendu avec une quantité inférieure à 1 car le nombre de pièce dans cet article est égal à 1'
             ];
           }
           return $this->respond([
             'status' => 400,
             'message' =>$message,
             'data'=> null
           ]);
         }else{
           $Qte = (int)$qqte[0]/ (int)$data[0]->nombre_piece;

         }
       }else{
         $Qte = $qqte[0];
         if($Qte < 1 || $Qte ==0){
           $message = [
             'success' =>null,
             'errors'=>'La quantité ne doit pas être inférieur à 1'
           ];
           return $this->respond([
             'status' => 400,
             'message' =>$message,
             'data'=> null
           ]);
         }
       }
       // CHECK IF THIS ARTICLE IS ALLOW TO BE BUY WITH PRICE INFERIEUR A 1
       if($Qte < 1 and $data[0]->nombre_piece < 2){
         $message = [
           'success' =>null,
           'errors'=>'Cet article ne peut pas être vendu avec une quantité inférieure à 1 car le nombre de pièce dans cet article est égal à 1'
         ];
         return $this->respond([
           'status' => 400,
           'message' =>$message,
           'data'=> null
         ]);
       }
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
           'errors'=>'Impossible de trouver cet article dans le dépot, veuillez contacter l\'administrateur du système'
         ];
         $data = null;
       }else{
         if($Qte <= $initqte->qte_stock_virtuel){
         // return $this->respond([$initqte->qte_stock]);
         if($data[0]->logic_detail_data && count($data[0]->logic_detail_data) > 1){
               $PU = null;
               $interval = null;
               $message = null;
               foreach ($data[0]->logic_detail_data as $key => $value) {
                  if($value->qte_decideur_min <= $Qte and $Qte < $value->qte_decideur_max){
                    $PU = $value->prix_unitaire;
                    $interval = $value->qte_decideur_min.' - '.$value->qte_decideur_max;
                  }
               }
               //CHECK IF THIS SPECIFIC CONFIG EXIST
               if (!$PU and !$interval) {
                 // code...
                 $status = 400;
                 $message = [
                   'success' =>null,
                   'errors'=>'Cet article ne possède pas les configurations de prix pour cette quantité! Veuillez svp contacter l\'administrateur ou le manager'
                 ];
                 $data = null;
               }else{
                 //CHECK IF FAVEUR THEN APPLY GROS PRICE
                 if($isFaveur == 1){
                   $ConfigFaveur = $this->articlesConfigFaveurModel->Where('articles_id',$data[0]->id)->findAll();
                   if($ConfigFaveur){
                     $QteToOfferFaveur = $ConfigFaveur[0]->qte_faveur;
                     if($Qte <= $QteToOfferFaveur){
                       $PU =  $ConfigFaveur[0]->prix_id[0]->prix_unitaire;
                       $interval = $ConfigFaveur[0]->prix_id[0]->qte_decideur_min.' - '.$ConfigFaveur[0]->prix_id[0]->qte_decideur_max;
                       $message = "avec une reduction";
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
                         'interval' => $interval,

                       ];
                     }else{
                       $status = 400;
                         $message = [
                           'success' =>null,
                           'errors'=>'En activant Faveur sur cet article la quantité ne doit pas depasser '.$QteToOfferFaveur
                         ];
                         $data = null;
                     }
                   }else{
                       $status = 400;
                       $message = [
                         'success' =>null,
                         'errors'=>'Cet article ne possède des configurations faveur, veuillez contacter l\'administrateur ou le manager'
                       ];
                       $data = null;

                   }

                 }else{
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
                     'interval' => $interval,
                     'qteStock' => $initqte->qte_stock_virtuel

                   ];
                 }

                 //ERROR SI FAVEUR MAIS QUANTITE N'EST PAS LA BONNE
                 // if($isFaveur == 1 and $Qte > $QteToOfferFaveur){
                 //   $status = 400;
                 //   $message = [
                 //     'success' =>null,
                 //     'errors'=>'En activant Faveur sur un article la quantité ne doit pas depasser 2'
                 //   ];
                 //   $data = null;
                 // }

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
       'data'=>$data,
       // 'msg' => fmod($calc, 1) == 0.00
     ]);
     // print_r($ConfigFaveur[0]->articles_id);

  }
  public function article_search_by_code($code){
    $data = $this->model->select('id,nom_article,code_article')->Where('code_article',$code)->find();
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
    ]);
  }
  public function article_update_price(){
    $idprice = $this->request->getPost('price_id');
    $newPrice = $this->request->getPost('prix_unitaire');
    if(is_numeric ($newPrice)){
      $data =[
        'prix_unitaire'=>$newPrice,
      ];
      $info = $this->articlesPrixModel->find($idprice);
      if($this->articlesPrixModel->update($info->id,$data)){

        $dataHistorique =[
          'prix_id'=>$info->id,
          'prix_unitaire'=>$newPrice,
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
            'success' =>'Modification du prix avec succès',
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
  public function article_delete_price($idprice){
    if($this->articlesPrixModel->delete(['id' =>$idprice ])){
      $status = 400;
      $message = [
        'success' =>'La configuration du prix d\'article a été supprimée',
        'errors'=>null
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' =>null,
        'errors'=>['Echec de la supprission contacter le concepteur système']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);

  }
  public function article_search_for_appro_inter_depot($codeArticle,$qte,$depotid,$idUser){
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

      $condtionPersonnel = [
        'users_id'=>$idUser,
        'articles_id' =>$data[0]->id
      ];
      //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
      $initqte = $this->stockModel->getWhere($condition)->getRow();
      $initqtePersonnel = $this->stockPersonnelModel->getWhere($condtionPersonnel)->getRow();
      if(!$initqte or !$initqtePersonnel){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'Impossible de trouver cet article dans le dépôt ou dans votre stock personnel veuillez contacter l\'administrateur du système'
        ];
        $data = null;
      }else{
        if($Qte <= $initqte->qte_stock_virtuel and $Qte <= $initqte->qte_stock){
          if($Qte <= $initqtePersonnel->qte_stock){
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
              'errors'=>'La quantité à approvisionner doit être inférieure ou égale à la quantité  réelle personnel'
            ];
            $data = null;
          }


      }else{
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'La quantité à approvisionner doit être inférieure ou égale à la quantité physique et réelle dans le dépôt général'
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
  public function create_configuration_faveur_article(){
    $this->model->beginTrans();
    $data = $this->request->getPost();
    $insertData = $this->articlesConfigFaveurModel->insert($data);
    if(!$insertData){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->articlesConfigFaveurModel->errors()
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' => 'Enregistrement de la configuration faveur avec succès',
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
  public function article_configuration_faveur_article(){
    $idprice = $this->request->getPost('config_faveur_id');
    $prix_id = $this->request->getPost('prix_id');
    $qte_faveur = $this->request->getPost('qte_faveur');

    if(is_numeric ($qte_faveur)){
      $data =[
        'prix_id'=>$prix_id,
        'qte_faveur'=>$qte_faveur,
      ];
      // $info = $this->articlesPrixModel->find($idprice);
      if(!$this->articlesConfigFaveurModel->update($idprice,$data)){
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>$this->articlesConfigFaveurModel->errors()
          ];
          $data = null;

      }else{
        $status = 200;
        $message = [
          'success' =>'La modification de la configuration faveur reussie avec succès',
          'errors'=>null
        ];
        $data = null;
      }

    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>['La quantité Faveur est invalide']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);
  }
  public function article_activate_visibilite_sur_rapport($idArticle){
    $data = $this->model->find($idArticle);
    $statusArticle = $data->is_show_on_rapport==1?0:1;
    if(!$this->model->set('is_show_on_rapport',$statusArticle)->Where('id',$idArticle)->update()){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' => $statusArticle==0?'Article activé pour être visible sur le rapport':'Article désactivé pour ne pas être visible sur le rapport',
        'errors' => $data->is_show_on_rapport
      ];
      $data = 'null';
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);

  }
  public function article_set_kg_pv(){
    $data = $this->request->getPost();
    $art = $this->model->find($data['idarticle']);
    if(!$this->model->update($data['idarticle'],['pv_en_kg'=>$data['kg'] + $art->pv_en_kg,'is_eligible_add_kg'=>1])){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' => 'Mis à jour des Kg PV effectué avec succès',
        'errors' => null
      ];
      $data = 'null';
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function article_update($id){
    $data = $this->request->getJSON();
    $updateData = $this->model->update($id,$data);
    if(!$updateData){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>'Le code article existe déjà'
      ];
    }else{
      $status = 200;
      $message = [
        'success' => 'Mise à jour reussie',
        'errors' => null
      ];
      $data = $updateData;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);
  }
  public function article_search_for_transfert($codeArticle,$qte,$usersid){
    $codeArt = $codeArticle;
    $Qte = $qte;
    $usersid = $usersid;
    $data = $this->model->Where('code_article',$codeArt)->find();
    if($data){
      //CHECK IF DEPOT HAS THIS QUANTIY
      $condition =[
        'users_id'=>$usersid,
        'articles_id'=>$data[0]->id
      ];
      //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
      $initqte = $this->stockPersonnelModel->getWhere($condition)->getRow();
      if(!$initqte){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'Impossible de trouver cet article dans le stock personnel veuillez contacter l\'administrateur du système'
        ];
        $data = null;
      }else{
        if($Qte <= $initqte->qte_stock){
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
          'errors'=>'La quantité à transfèrer doit être inférieure ou égale à votre quantité réelle personnelle'
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

  public function article_search_for_pv_perdue($codeArticle,$qte,$depotid,$idUser){
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

      $condtionPersonnel = [
        'users_id'=>$idUser,
        'articles_id' =>$data[0]->id
      ];
      //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
      $initqte = $this->stockModel->getWhere($condition)->getRow();
      $initqtePersonnel = $this->stockPersonnelModel->getWhere($condtionPersonnel)->getRow();
      if(!$initqte or !$initqtePersonnel){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'Impossible de trouver cet article dans le dépôt ou dans le stock personnel veuillez contacter l\'administrateur du système'
        ];
        $data = null;
      }else{
        if($Qte <= $initqte->qte_stock_virtuel and $Qte <= $initqte->qte_stock){
          if($Qte <= $initqtePersonnel->qte_stock){
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
              'errors'=>'La quantité perdue doit être inférieure ou égale à la quantité  réelle personnel'
            ];
            $data = null;
          }

      }else{
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'La quantité perdue doit être inférieure ou égale à la quantité physique et réelle dans le dépôt général'
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
  public function article_set_prix_transport(){
    $this->transportPrixArticlesModel->beginTrans();
    $data = $this->request->getPost();

    if(!$this->transportPrixArticlesModel->checkingIfConfigExist($data['zone_id'], $data['article_id'])){
      $insertData = $this->transportPrixArticlesModel->insert($data);
      if(!$insertData){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->transportPrixArticlesModel->errors()
        ];
        $data = null;
      }else{

        $status = 200;
        $message = [
          'success' => 'Enregistrement du prix de l\'article reussi avec succès',
          'errors' => null
        ];
        $data = 'null';
      }
    }else{
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>['cet article possède déjà une configuration dans cette zone']
      ];
      $data = null;
    }

    $this->transportPrixArticlesModel->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function article_delete_price_transport($idprice){
    if($this->transportPrixArticlesModel->delete(['id' =>$idprice ])){
      $status = 400;
      $message = [
        'success' =>'La configuration du prix de transport d\'article a été supprimée',
        'errors'=>null
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' =>null,
        'errors'=>['Echec de la supprission contacter le concepteur système']
      ];
      $data = null;
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data,

    ]);

  }
  public function article_update_price_transport(){
    $idprice = $this->request->getPost('price_id');
    $newPrice = $this->request->getPost('prix');
    if(is_numeric ($newPrice) and $newPrice > 0){
      $data =[
        'prix'=>$newPrice,
      ];

      if($this->transportPrixArticlesModel->update($idprice,$data)){
          $status = 400;
          $message = [
            'success' =>'Modification du prix de transport avec succès',
            'errors'=>null
          ];
          $data = null;
      }else{
          $status = 400;
          $message = [
            'success' =>null,
            'errors'=>['Erreur de la mise à jour']
          ];
          $data = null;
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
  public function multitest(){
    print_r($this->request->getPost());

  }
}
