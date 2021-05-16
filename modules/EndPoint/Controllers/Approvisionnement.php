<?php

namespace Modules\EndPoint\Controllers;
use CodeIgniter\RESTful\ResourceController;
use App\Entities\ApprovisionnementsEntity;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\StockModel;
use App\Models\ArticlesModel;
use App\Models\PvRestaurationModel;
use App\Models\ClotureStockModel;
use App\Models\StockPersonnelModel;
use App\Models\PvPerdueHistoriqueModel;
use App\Models\PvPerdueHistoriqueDetailModel;

use App\Entities\StockEntity;
use App\Entities\PvRestaurationEntity;
use App\Entities\ClotureStockEntity;
use CodeIgniter\I18n\Time;




class Approvisionnement extends ResourceController {
  protected $format = 'json';
  protected $modelName = '\App\Models\ApprovisionnementsModel';
  protected $approvisionnementsDetailModel = null;
  protected $stockModel = null;
  protected $articlesModel = null;
  protected $pvRestaurationModel = null;
  protected $clotureStockModel = null;
  protected $stockPersonnelModel = null;
  protected $pvPerdueHistoriqueModel = null;
  protected $pvPerdueHistoriqueDetailModel = null;



  public function __construct(){
    helper(['global']);
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    $this->stockModel = new StockModel();
    $this->articlesModel = new ArticlesModel();
    $this->pvRestaurationModel = new PvRestaurationModel();
    $this->clotureStockModel = new ClotureStockModel();
    $this->stockPersonnelModel = new StockPersonnelModel();
    $this->pvPerdueHistoriqueModel = new PvPerdueHistoriqueModel();
    $this->pvPerdueHistoriqueDetailModel = new PvPerdueHistoriqueDetailModel();


  }
  public function approvisionnement_get($dateFilter,$limit, $offset){
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
  public function approvisionnement_create(){
    $this->model->beginTrans();
    $data = new ApprovisionnementsEntity($this->request->getPost());
    if(!$insertData = $this->model->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->model->errors()
      ];
      $data = null;
    }else{
      //CREATE LIGNE STOCK PERSONNEL IF NOT EXIST
      $this->stockPersonnelModel->insertArticleInStockPersonnelIfNotExit($data->users_id->id);

      //CREATE COMMANDE  DETAIL AVEC ARTICLE STOCK
      $nArt = count($data->articles_id);
      $article = $data->articles_id;
      $qte = $data->qte;
      $qte_total = $data->qte_total;
      $qte_pv = $data->qte_pv;

      for ($i=0; $i < $nArt; $i++) {
        $dataDetail = [
          'approvisionnement_id'=>$insertData,
          'articles_id'=>$article[$i],
          'qte'=>$qte[$i],
          'qte_total'=>$qte_total[$i],
          'qte_pv'=>$qte_pv[$i]
        ];
        if(!$this->approvisionnementsDetailModel->insert($dataDetail)){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsDetailModel->errors()
          ];
          return $this->respond([
            'status' => '400',
            'message' =>$message,
            'data'=>""
          ]);
        }

        if($qte_pv[$i] > 0){
          $this->articlesModel->update($article[$i],['is_eligible_add_kg'=>0]);
        }
        //UPDATE STOCK IN STOCK
        $condition =[
          'depot_id'=>$this->request->getPost('depots_id'),
          'articles_id'=>$article[$i]
        ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqte = $this->stockModel->getWhere($condition)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $Qte = $initqte->qte_stock + $qte[$i];//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuel = $initqte->qte_stock_virtuel + $qte[$i];

        //UPDATE AND ADD TO QTE PERSONNEL
        $udpateStockPersonnel = $this->stockPersonnelModel->updateQtePersonnel($data->users_id->id,$article[$i], $qte[$i]);

        // return $this->respond([$initqte]);

        if(!$this->stockModel->update($initqte->id,['qte_stock'=>$Qte,'qte_stock_virtuel'=>$QteVirtuel]) || !$udpateStockPersonnel){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->stockModel->errors()
          ];
          return $this->respond([
            'status' => '400',
            'message' =>$message,
            'data'=> $dtStock
          ]);
        }

        //ADD PV TO STOCK PV
        $getSpecificArticlePvStock = $this->articlesModel->find($article[$i]);
        $newPvStock = $getSpecificArticlePvStock->qte_stock_pv + $qte_pv[$i];
        if(!$this->articlesModel->update($article[$i],['qte_stock_pv'=>$newPvStock])){
          $this->model->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->articlesModel->errors()
          ];
          return $this->respond([
            'status' => '400',
            'message' =>$message,
            'data'=> $dtStock
          ]);
        }

      }

      $status = 200;
      $message = [
        'success' => 'Le dépôt a été bien approvisionné',
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
  public function approvisionnement_get_by_depot($idDepot,$limit, $offset,$dateFilter){
    $d = Time::today();
    if($dateFilter == "null"){ $dateFilter = $d; }
    $conditionDate =['date_approvisionnement'=> $dateFilter];

    $data = $this->model->Where($conditionDate)->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll($limit,$offset);
    return $this->respond([
      'status' => 200,
      'message' => 'success',
      'data' => $data,
      'all'=> count($data = $this->model->Where($conditionDate)->Where('depots_id',$idDepot)->orderBy('id','DESC')->findAll())
    ]);
  }
  public function approvisionementPvRestaure(){
    $this->pvRestaurationModel->beginTrans();
    $data = new PvRestaurationEntity($this->request->getPost());
    if(!$insertData = $this->pvRestaurationModel->insert($data)){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->pvRestaurationModel->errors()
      ];
      $data = null;
    }else{
      $artInfo = $this->articlesModel->find($data->articles_id);
      $newQte = $artInfo->qte_stock_pv - $data->qte_restaure;

      $newQteKg = $artInfo->pv_en_kg - $data->pv_en_kg;
      if($data->qte_perdue > 0){
        $newQte = $artInfo->qte_stock_pv - ($data->qte_restaure+$data->qte_perdue);
      }
      if(!$this->articlesModel->update($data->articles_id, ['qte_stock_pv'=>$newQte, 'pv_en_kg'=>$newQteKg])){
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>$this->articlesModel->errors()
        ];
        $data = null;
      }else{
        //UPDATE STOCK IN STOCK
        $condition =[
          'depot_id'=>$data->depots_id_dest[0]->id,
          'articles_id'=>$data->articles_id
        ];

        //CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
        $initqte = $this->stockModel->getWhere($condition)->getRow();//RECUPERATION DE LA LIGNE DANS STOCK
        $Qte = $initqte->qte_stock + $data->qte_restaure;//ADDITION ANCIENNE + NOUVELLE
        $QteVirtuel = $initqte->qte_stock_virtuel + $data->qte_restaure;

        //UPDATE STOCK PERSONNEL MAGAZINIER DESTINATION RESTATURATION
        $udpateStockPersonnel = $this->stockPersonnelModel->updateQtePersonnel($data->magaz_dest_id->id,$data->articles_id, $data->qte_restaure);

        if(!$this->stockModel->update($initqte->id,['qte_stock'=>$Qte,'qte_stock_virtuel'=>$QteVirtuel]) OR !$udpateStockPersonnel){
          $this->pvRestaurationModel->RollbackTrans();
          $message = [
            'success' =>null,
            'errors'=>$this->approvisionnementsDetailModel->errors()
          ];
          return $this->respond([
            'status' => '400',
            'message' =>$message,
            'data'=>""
          ]);
        }else{
          $status = 200;
          $message = [
            'success' => 'Le dépôt a été bien approvisionné par le(s) PV restauré(s)',
            'errors' => null
          ];
          $data = null;
        }
      }
    }
    $this->pvRestaurationModel->commitTrans();
     return $this->respond([
       'status' => $status,
       'message' =>$message,
       'data'=> $data
     ]);
  }
  public function clotureJournalierStock(){
    $d = Time::tomorrow();
    $initStock = $this->stockModel->findAll();
    if(!$this->clotureStockModel->Where('date_cloture',$d)->find()){
      foreach ($initStock as $key => $value) {
        $data = [
          'articles_id'=>$value->articles_id[0]->id,
          'depot_id' =>$value->depot_id,
          'qte_stock' =>$value->qte_stock,
          'qte_stock_virtuel' =>$value->qte_stock_virtuel,
          'date_cloture' =>$d
        ];

        $insertData = $this->clotureStockModel->insert($data);
      }
      //echo 'cloture avec success';
      $message = [
        'success' => "La cloture journalière du stock a été effectuée avec succès",
        'errors' => null
      ];
    }else{
      $message = [
        'success' => null,
        'errors' => ["Merci de reessayer demain car la cloture journalière du stock est déjà faite"]
      ];
    }
    return $this->respond([
      'status' => 200,
      'message' =>$message,
      // 'data'=> $data
    ]);
  }
  public function ajustementStockDepot($idArticle, $idDepot, $newQteReelle, $newQteVirtuelle){

    $getLine = $this->stockModel->Where('articles_id',$idArticle)->Where('depot_id',$idDepot)->find();
    if(!$this->stockModel->update($getLine[0]->id, ['qte_stock'=>$newQteReelle, 'qte_stock_virtuel'=>$newQteVirtuelle])){
      $status = 400;
      $message = [
        'success' =>null,
        'errors'=>$this->stockModel->errors()
      ];
      $data = null;
    }else{
      $status = 200;
      $message = [
        'success' =>"Ajustement des stocks virtuel et réel avec succès",
        'errors'=>null
      ];
      $data = null;
    }

    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $data
    ]);
  }

  public function addHistoriquePv(){
    $depot = $this->request->getPost('depots_id');
    $magaz_source = $this->request->getPost('magaz_source_id');
    $articles = $this->request->getPost('articles_id');
    $qte_perdue = $this->request->getPost('qte_perdue');
    $users_id = $this->request->getPost('users_id');
    $dateHistorique = $this->request->getPost('date_historique');

    $this->pvPerdueHistoriqueModel->beginTrans();
    $dat = [
      'depots_id'=>$depot,
      'date_historique' =>$dateHistorique,
      'magaz_source_id'=>$magaz_source,
      'users_id'=>$users_id
    ];
    $idHistorique = $this->pvPerdueHistoriqueModel->insert($dat);

    //verfication si quantite est disponible dans le stock reel et virtuel
    for ($i=0; $i < count($articles); $i++) {
      // code...
      $condition =[
        'depot_id'=>$depot,
        'articles_id'=>$articles[$i]
      ];//CONDITION POUR TROUVER LA BONNE LIGNE DANS STOCK
      $condtionPersonnel = [
        'users_id'=>$magaz_source,
        'articles_id' =>$articles[$i]
      ];
      $initqte = $this->stockModel->getWhere($condition)->getRow();
      $initqtePersonnel = $this->stockPersonnelModel->getWhere($condtionPersonnel)->getRow();
      if($initqte and $initqtePersonnel){
          if($qte_perdue[$i] <= $initqte->qte_stock_virtuel and $qte_perdue[$i] <= $initqte->qte_stock){
            if($qte_perdue[$i] <= $initqtePersonnel->qte_stock){
              $Qte = $initqte->qte_stock - $qte_perdue[$i];//ADDITION ANCIENNE + NOUVELLE
              $QteVirtuel = $initqte->qte_stock_virtuel - $qte_perdue[$i];
              //UPDATE AND ADD TO QTE PERSONNEL
              $udpateStockPersonnel = $this->stockPersonnelModel->updateQtePersonnel($magaz_source,$articles[$i], $qte_perdue[$i],0);
              if($this->stockModel->update($initqte->id,['qte_stock'=>$Qte,'qte_stock_virtuel'=>$QteVirtuel])){
                //create line histoirque
                if($idHistorique){
                  $datDetail = [
                    'pv_historique_id' =>$idHistorique,
                    'articles_id'=>$articles[$i],
                    'qte_perdue'=>$qte_perdue[$i],
                  ];

                  if($this->pvPerdueHistoriqueDetailModel->insert($datDetail)){
                    $status = 200;
                    $message = [
                      'success' => 'Les quantités PV ont a été bien rétirer avec succès',
                      'errors' => null
                    ];
                    $data = null;
                  }else{
                    $status = 400;
                    $message = [
                      'success' => null,
                      'errors' => $this->pvPerdueHistoriqueDetailModel->errors()
                    ];
                    $data = null;
                 }
                }else{
                  $status = 400;
                  $message = [
                    'success' => null,
                    'errors' => $this->pvPerdueHistoriqueModel->errors()
                  ];
                  $data = null;
                }
              }else{
                $status = 400;
                $message = [
                  'success' =>'Action reussie, reussi mais c\'est probable que certaines actions n\'aient pas abouties! Veuillez verifier l\'historique afin de voir quel article a été affecté',
                  'errors'=> null
                ];
                $data = null;
              }
            }else{
              $status = 400;
              $message = [
                'success' =>'Action reussie, reussi mais c\'est probable que certaines actions n\'aient pas abouties! Veuillez verifier l\'historique afin de voir quel article a été affecté',
                'errors'=> null
              ];
              $data = null;
            }
          }else{
            $status = 200;
            $message = [
              'success' =>'Action reussie, reussi mais c\'est probable que certaines actions n\'aient pas abouties! Veuillez verifier l\'historique afin de voir quel article a été affecté',
              'errors'=> null
            ];
            $data = null;
          }
      }else{
        $status = 400;
        $message = [
          'success' =>null,
          'errors'=>'Impossible de trouver cet article dans le dépôt ou dans le stock personnel veuillez contacter l\'administrateur du système'
        ];
        $data = null;
      }
    }
    $this->pvPerdueHistoriqueModel->commitTrans();

    return $this->respond([
      'status' => $status,
      'message' =>$message,
      'data'=> $idHistorique
    ]);




  }
}
