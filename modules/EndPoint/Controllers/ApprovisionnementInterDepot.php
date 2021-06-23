<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ApprovisionnementsInterDepotEntity;
use App\Models\ApprovisionnementsInterDepotDetailModel;
use App\Models\StockModel;
use App\Entities\StockEntity;
use App\Models\UsersAuthModel;
use App\Models\StockPersonnelModel;
use CodeIgniter\I18n\Time;




class ApprovisionnementInterDepot extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ApprovisionnementsInterDepotModel';
  protected $approvisionnementsInterDepotDetailModel = null;
  protected $stockModel = null;
  protected $usersAuthModel = null;
  protected $stockPersonnelModel = null;






  public function __construct(){
    helper(['global']);
    $this->approvisionnementsInterDepotDetailModel = new ApprovisionnementsInterDepotDetailModel();
    $this->stockModel = new StockModel();
    $this->usersAuthModel = new UsersAuthModel();
    $this->stockPersonnelModel = new StockPersonnelModel();

  }
  public function approvisionnementInterDepot_get($limit, $offset,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_approvisionnement'=> $dateFilter];
    $data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where($conditionDate)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function approvisionnementInterDepot_create(){
    $this->model->beginTrans();
    $data = new ApprovisionnementsInterDepotEntity($this->request->getPost());
    if(!$insertData = $this->model->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      //CREATE LIGNE STOCK PERSONNEL IF NOT EXIST
      // $this->StockPersonnelModel->insertArticleInStockPersonnelIfNotExit($data->users_id->id);
      //CREATE COMMANDE  DETAIL AVEC ARTICLE STOCK
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte = $data->qte;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'approvisionnement_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte'=>$qte[$i],
        ];
        if(!$this->approvisionnementsInterDepotDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsInterDepotDetailModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=>""
          ]);
        }

        //UPDATE STOCK IN STOCK DEPOT SOURCE
        $conditionSource =[
          'depot_id'=>$data->depots_id_source[0]->id,
          'articles_id'=>$article[$i]
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        //$QteSource = $initqteSource->qte_stock - $qte[$i];//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuelSource = $initqteSource->qte_stock_virtuel - $qte[$i];
        // return $this->respond([$initqte]);
        $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock_virtuel'=>$QteVirtuelSource]);
      }

      $status = 200;
      $message = [
        'success' => 'Approvisionnement reussi mais reste en attente de validation',
        'errors' => null
      ];
      $data = null;
    }
    $this->model->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function approvisionnementInterDepot_get_by_depot($idDepot,$limit, $offset,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_approvisionnement'=> $dateFilter];
    $conditionSource = [
      'depots_id_source'=>$idDepot,
      'date_approvisionnement'=> $dateFilter
    ];
    $conditionDest= [
      'depots_id_dest'=>$idDepot,
      'date_approvisionnement'=> $dateFilter
    ];
    $where = "(depots_id_dest='".$idDepot."' or depots_id_source='".$idDepot."') and date_approvisionnement='".$dateFilter."'";


    $data = $this->model->Where($where)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where($where)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function validateApprovisionnementInterDepot($pwd,$idAppro,$iduser){
    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      $infoAppro = $this->model->find($idAppro);
      $depot_source = $infoAppro->depots_id_source[0]->id;
      $depot_dest = $infoAppro->depots_id_dest[0]->id;
      $userSource = $infoAppro->users_id->id;



      $data = ['status_operation'=>2,'user_id_valid'=>$iduser];
      if(!$updateData = $this->model->update($idAppro,$data)){
        $status = 400;
        $message = [
          'success' => null,
          'errors' => $this->model->erros()
        ];
        $data = "";
      }else{
        $allArt = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id',$idAppro)->Where('is_validate',0)->findAll();
        foreach ($allArt as $key => $value) {
          //UPDATE STOCK IN STOCK DEPOT DESTINATION
          $conditionDest =[
            'depot_id'=>$depot_dest,
            'articles_id'=>$value->articles_id[0]->id
          ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
          $initqteDest = $this->stockModel->getWhere($conditionDest)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK

          $QteDest = $initqteDest->qte_stock +$value->qte;//ADDITION ANCIENNE + NOUVELLE
          $QteVirtuelDest = $initqteDest->qte_stock_virtuel + $value->qte;

          //UPDATE STOCK IN STOCK DEPOT SOURCE
          $conditionSource =[
            'depot_id'=>$depot_source,
            'articles_id'=>$value->articles_id[0]->id
          ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
          $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
          $QteSource = $initqteSource->qte_stock - $value->qte;//ADDITION ANCIENNE + NOUVELLE
          // $QteVirtuelSource = $initqteSource->qte_stock_virtuel - $value->qte;
          // return $this->respond([$initqte]);

          //UPDATE STOCK PERSONNEL
          $this->stockPersonnelModel->updateQtePersonnel($iduser,$value->articles_id[0]->id,$value->qte); //STOCK PERSONNEL DESTINATION
          $this->stockPersonnelModel->updateQtePersonnel($userSource,$value->articles_id[0]->id,$value->qte,0); //STOCK PERSONNEL SOURCE

          // updateQtePersonnel($idUser, $idArticle, $newQteToUpdate,$paramAction=1)

          $updStockDest = $this->stockModel->update($initqteDest->id,['qte_stock'=>$QteDest,'qte_stock_virtuel'=>$QteVirtuelDest]);

          $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock'=>$QteSource]);

          $this->approvisionnementsInterDepotDetailModel->update($value->id, ['is_validate'=>1]);
        }

        if(!$updStockDest and !$updStockSource){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->stockModel->errors()
          ];
          return $this->respond([
            'status' => '200',
            'message' =>$message,
            'data'=> $dtStock
          ]);
        }

        $status = 200;
        $message = [
          'success' => 'L\'approvisionnement a été validé avec succès',
          'errors' => null
        ];
        $data = null;
      }
    }
    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }
  public function annuler_approvisionnement_inter_depot(){
    $pwd = $this->request->getPost('pwd');
    $idappro = $this->request->getPost('idappro');
    $iduser = $this->request->getPost('iduser');

    if(!$this->usersAuthModel->authPasswordOperation($iduser,$pwd)){
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ["Mot de passe des opérations incorrect"]
      ];
      $data = "";
    }else{
      //SUITES VALIDATIONS
      $nbrAnnule = 1;
      for ($i=0; $i < count($idappro); $i++) {
        $data = ['status_operation'=>3];
        if(!$updateData = $this->model->update($idappro[$i],$data)){
          $status = 400;
          $message = [
            'success' => null,
            'errors' => $this->model->erros()
          ];
          $data = "";
        }else {
          $infoAppro = $this->model->find($idappro[$i]);
          $allArticleIn = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id',$idappro[$i])->findAll();
          foreach ($allArticleIn as $key => $value) {
            // code...

            //UPDATE STOCK IN STOCK DEPOT SOURCE
            $conditionSource =[
              'depot_id'=>$infoAppro->depots_id_source[0]->id,
              'articles_id'=>$value->articles_id[0]->id
            ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
            $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
            //$QteSource = $initqteSource->qte_stock - $qte[$i];//ADDITION ANCIENNE + NOUVELLE
            $QteVirtuelSource = $initqteSource->qte_stock_virtuel + $value->qte;
            // return $this->respond([$initqte]);
            $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock_virtuel'=>$QteVirtuelSource]);
          }

          $status = 200;
          $message = [
            'success' => $nbrAnnule++ .' Approvisionnement(s) annulé(s) avec succès',
            'errors' => null
          ];
          $data = "";
        }
      }
    }
    // $this->model->RollbackTrans();
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }
  public function approvisionnement_delete_articles(){
    $idappro = $this->request->getPost('idappro');
    $idarticle = $this->request->getPost('idarticle');
    $getAllarticleDeLAppro = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id', $idappro)->findAll();
    if(count($idarticle) < count($getAllarticleDeLAppro)){
    for ($i=0; $i < count($idarticle); $i++) {
        $condition = [
          'approvisionnement_id' =>$idappro,
          'articles_id'=>$idarticle[$i]
        ];
        $data = $this->approvisionnementsInterDepotDetailModel->getWhere($condition)->getRow();

        $infoAppro = $this->model->find($idappro);
        $allArticleIn = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id',$idappro)->Where('articles_id',$idarticle[$i])->find();
          //UPDATE STOCK IN STOCK DEPOT SOURCE
          $conditionSource =[
            'depot_id'=>$infoAppro->depots_id_source[0]->id,
            'articles_id'=>$allArticleIn[0]->articles_id[0]->id
          ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
          $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
          //$QteSource = $initqteSource->qte_stock - $qte[$i];//ADDITION ANCIENNE + NOUVELLE
          $QteVirtuelSource = $initqteSource->qte_stock_virtuel + $allArticleIn[0]->qte;
          // return $this->respond([$initqte]);
          $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock_virtuel'=>$QteVirtuelSource]);
          if($updStockSource){
            if($this->approvisionnementsInterDepotDetailModel->delete(['id' =>$data->id ])){
              $textArt = $i > 1 ? 'ont':'a';
              $status = 200;
              $message = [
                'success' => ($i+1).' article(s) de cet approvisionnement '.$textArt.' été supprimer avec succès',
                'errors' => null
              ];
              $data = "";

            }else{
              $status = 400;
              $message = [
                'success' => null,
                'errors' => "Echec de la suppression d'article"
              ];
              $data = "";
            }
          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => "Echec de la suppression d'article veuilez contactez l'administrateur"
            ];
            $data = "";
          }
      }
    }else{
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ['Impossible de supprimer tous les articles de l\'approvisionnement!']
      ];
      $data = "";
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }
  public function approvisionnement_validate_partiel_articles(){
    $idappro = $this->request->getPost('idappro');
    $idarticle = $this->request->getPost('idarticle');
    $getAllarticleDeLAppro = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id', $idappro)->Where('is_validate', 0)->findAll();
    if(count($idarticle) < count($getAllarticleDeLAppro)){
    for ($i=0; $i < count($idarticle); $i++) {
        $condition = [
          'approvisionnement_id' =>$idappro,
          'articles_id'=>$idarticle[$i]
        ];
        $data = $this->approvisionnementsInterDepotDetailModel->getWhere($condition)->getRow();

        $infoAppro = $this->model->find($idappro);
        $allArticleIn = $this->approvisionnementsInterDepotDetailModel->Where('approvisionnement_id',$idappro)->Where('articles_id',$idarticle[$i])->find();
        //UPDATE STOCK IN STOCK DEPOT DESTINATION
        $conditionDest =[
          'depot_id'=>$infoAppro->depots_id_dest[0]->id,
          'articles_id'=>$allArticleIn[0]->articles_id[0]->id
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqteDest = $this->stockModel->getWhere($conditionDest)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK

        $QteDest = $initqteDest->qte_stock +$allArticleIn[0]->qte;//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuelDest = $initqteDest->qte_stock_virtuel + $allArticleIn[0]->qte;

          //UPDATE STOCK IN STOCK DEPOT SOURCE
          $conditionSource =[
            'depot_id'=>$infoAppro->depots_id_source[0]->id,
            'articles_id'=>$allArticleIn[0]->articles_id[0]->id
          ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
          $initqteSource = $this->stockModel->getWhere($conditionSource)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
          $QteSource = $initqteSource->qte_stock - $allArticleIn[0]->qte;//ADDITION ANCIENNE + NOUVELLE

          $updStockDest = $this->stockModel->update($initqteDest->id,['qte_stock'=>$QteDest,'qte_stock_virtuel'=>$QteVirtuelDest]);

          $updStockSource = $this->stockModel->update($initqteSource->id,['qte_stock'=>$QteSource]);

          if($updStockSource and $updStockDest){
            if($this->approvisionnementsInterDepotDetailModel->update($allArticleIn[0]->id, ['is_validate'=>1]) and $this->model->update($idappro, ['status_operation'=>1])){
              $textArt = $i > 1 ? 'ont':'a';
              $status = 200;
              $message = [
                'success' => ($i+1).' article(s) de cet approvisionnement '.$textArt.' été validé avec succès ',
                'errors' => null
              ];
              $data = "";

            }else{
              $status = 400;
              $message = [
                'success' => null,
                'errors' => "Echec de la suppression d'article"
              ];
              $data = "";
            }
          }else{
            $status = 400;
            $message = [
              'success' => null,
              'errors' => "Echec de la suppression d'article veuilez contactez l'administrateur"
            ];
            $data = "";
          }
      }
    }else{
      $status = 400;
      $message = [
        'success' => null,
        'errors' => ['Impossible de valider tous les articles de l\'approvisionnement, veuillez par contre valider tout l\'approvisionnement dans son ensemble!']
      ];
      $data = "";
    }
    return $this->respond([
      'status' => $status,
      'message' => $message,
      'data' => $data
    ]);
  }
}
