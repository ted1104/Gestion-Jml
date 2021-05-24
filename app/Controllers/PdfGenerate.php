<?php

namespace App\Controllers;
use FPDF;
use App\Models\CommandesModel;
use App\Models\StDepotModel;
use App\Models\ArticlesModel;
use App\Models\CommandesDetailModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\ApprovisionnementsModel;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\ApprovisionnementsInterDepotDetailModel;
use App\Models\StockModel;
use App\Models\ClotureStockModel;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;
use App\Models\DecaissementModel;
use App\Models\EncaissementExterneModel;
use App\Models\DecaissementExterneModel;
use App\Models\CaisseModel;
use App\Models\ClotureCaisseModel;
use App\Models\PvPerdueHistoriqueModel;
use App\Models\PvPerdueHistoriqueDetailModel;



class PdfGenerate extends BaseController {
  protected $pdf;
  protected $commande;
  protected $depotModel = null;
  protected $articlesModel = null;
  protected $commandesDetailModel = null;
  protected $commandesStatusHistoriqueModel = null;
  protected $approvisionnementsDetailModel = null;
  protected $approvisionnementsInterDepotDetailModel = null;
  protected $stockModel = null;
  protected $clotureStockModel = null;
  protected $usersModel = null;
  protected $decaissementModel  = null;
  protected $encaissementExterneModel = null;
  protected $decaissementExterneModel = null;
  protected static $caisseModel = null;
  protected static $clotureCaisseModel = null;
  protected $approvisionnementModel =  null;
  protected $pvPerdueHistoriqueModel =  null;
  protected $pvPerdueHistoriqueDetailModel = null;



  public function __construct(){
    $this->pdf = new FPDF();
    $this->commande = new CommandesModel();
    $this->depotModel = new StDepotModel();
    $this->articlesModel = new ArticlesModel();
    $this->commandesDetailModel = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    $this->approvisionnementsInterDepotDetailModel = new ApprovisionnementsInterDepotDetailModel();
    $this->stockModel = new StockModel();
    $this->clotureStockModel = new ClotureStockModel();
    $this->usersModel = new UsersModel();
    $this->decaissementModel = new DecaissementModel();
    $this->encaissementExterneModel = new EncaissementExterneModel();
    $this->decaissementExterneModel = new DecaissementExterneModel();
    self::$caisseModel = new CaisseModel();
    self::$clotureCaisseModel = new ClotureCaisseModel();
    $this->approvisionnementModel = new ApprovisionnementsModel();
    $this->pvPerdueHistoriqueModel = new PvPerdueHistoriqueModel();
    $this->pvPerdueHistoriqueDetailModel = new PvPerdueHistoriqueDetailModel();

  }
  public function index($code){
    $data = $this->commande->find($code);
    // echo "<pre>";
    // print_r($data->logic_somme);
    // echo "</pre>";
    $this->pdf = new FPDF("L","pt", array(300,300));
    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();
    $this->pdf->Cell(190,10,'Date : '.$data->created_at,0,1,'C');
    // $this->pdf->Ln();
    $this->pdf->Cell(190,10,'Client : '.$data->nom_client,0,1,'C');
    // $this->pdf->Ln();
    $this->pdf->Cell(190,10,utf8_decode('Dépôt : '.$data->depots_id[0]->nom),0,1,'C');
    $this->pdf->Cell(190,10,utf8_decode('Caissier : '.$data->payer_a[0]->nom.' '.$data->payer_a[0]->prenom),0,1,'C');
    $this->pdf->Cell(190,10,utf8_decode('Montant Total : '.$data->logic_somme.' USD'),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',20);
    $this->pdf->Cell(190,40,$data->numero_commande,0,1,'C');
    // $this->pdf->Ln();
    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->Cell(190,10,'A retirer avant 17h00',0,1,'C');
    $date = Time::parse($data->created_at);
    $this->pdf->Cell(190,10,'Valable avant '.$date->addDays(6),0,1,'C');

    $this->outPut();


  }

  public function facture($code){
    $data = $this->commande->find($code);
    // print_r($data->logic_article);
    // exit();
    $this->pdf = new FPDF("L","pt", array(350,350));
    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->SetMargins(0,5,10);
    $this->pdf->AddPage();

    // $this->pdf->SetXY(5,5);

    $this->pdf->Cell(120,15,utf8_decode('FACTURE N° : '.$data->numero_commande),0,0,'L');
    $this->pdf->Cell(80,15,'Date : '.$data->created_at,0,1,'L');
    $this->pdf->Cell(200,15,'Nom du Client : '.$data->nom_client,0,1,'L');


    $this->pdf->Cell(200,15,'DETAIL ACHAT ',0,1,'C');
    $this->pdf->Ln();
    $header = ['Article', 'Qte', 'PU','PT'];
    $this->BasicTableHeader($header,290);
    $this->pdf->SetFont('Helvetica','',6);
    $montantTotalAchat = 0;
    foreach ($data->logic_article as $key => $value) {

      // $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;

      $prixUnitaire = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ? $value->prix_unitaire:$value->prix_negociation;

      $montantTotalParArticle = round($prixUnitaire * $value->qte_vendue,2);

      $this->pdf->Cell(125,15,utf8_decode($value->articles_id[0]->nom_article),1,0);
      $this->pdf->Cell(25,15,$value->qte_vendue,1,0);

      $this->pdf->Cell(25,15,utf8_decode($prixUnitaire.' USD'),1,0);
      $this->pdf->Cell(25,15,utf8_decode($montantTotalParArticle.' USD'),1,1);

      $montantTotalAchat += $montantTotalParArticle;
    }

    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->Cell(175,30,'TOTAL ',0,0,'R');
    $this->pdf->Cell(25,30,$montantTotalAchat.' USD',0,1,'L');
    $this->pdf->Ln(3);
    $this->outPut();
  }

  private function outPut(){
    $this->response->setHeader('Content-Type', 'application/pdf');
    $this->pdf->Output();
  }

  // FONCTIONS AIDES
  function BasicTableHeader($header, $widthMax)
    {
          $wCol = $widthMax/count($header);
          foreach($header as $col):
              //$wColN = $col==='Article'?$wCol+($wCol/2)*3-(8.75*3):$wCol/2+8.75;
              $wColN = $col==='Article'? 125:25;
              $this->pdf->Cell($wColN,15,$col,1);
          endforeach;
          $this->pdf->Ln();
      }

##################RAPPORT#############################

  public function rapport_journal_de_sorti_par_depot($idDepot,$dateRapport){
      $depotInfo = $this->depotModel->find($idDepot);
      $allArticle = $this->articlesModel->Where('is_show_on_rapport',1)->findAll();

      //===LISTE DES TOUTES LES FACTURES PAYES ET LIVRES AUJOURDHUI==========
      $AchatsHistoLivre = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->Where('g_interne_vente_historique_status.status_vente_id',3)->Where('depots_id',$idDepot)->groupBy('g_interne_vente_historique_status.vente_id')->findAll();

      // $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->Where('g_interne_vente_historique_status.status_vente_id',2)->Where('depots_id',$idDepot)->findAll(); PAR DATE
      //
      //===LISTE DES TOUTES LES FACTURES PAYES NON LIVREES DE TOUS LES JOURS ==========
      $AchatHistoroFacturePayeNonLivre = $this->commande->Where('depots_id',$idDepot)->Where('status_vente_id',2)->findAll();

      //===LISTE DES TOUTES LES FACTURES PAYES MAIS LIVREES PARTIELLEMENT DE TOUS LES JOURS ==========
      $AchatLivrePartiellement = $this->commande->Where('status_vente_id',3)->Where('is_livrer_all',1)->like('updated_at',$dateRapport,'after')->findAll(); //TOUTLES FACTURES PAYE MAIS LIVRER PARTIELLEMENT DU SYSTEME

      // ====CALCUL =====
      // ====CALCUL =====
      // ====CALCUL =====

      //=== CALCUL DU TOTAL VENDU :: TOUTES LES FACTURES PAYES
      $AchatsHistoFacturePayeCalcul = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->Where('g_interne_vente_historique_status.status_vente_id',2)->Where('depots_id',$idDepot)->findAll();
      // $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',2)->Where('depots_id',$idDepot)->findAll(); //TOUTLES FACTURES PAYE MAIS NON LIVRER DU SYSTEME



      // $AchatLivrePartiellement = $this->commande->Where('status_vente_id',3)->Where('is_livrer_all',1)->like('updated_at',$dateRapport,'after')->findAll(); LIVRER PARTIELLEMENT PAR DATE


      $this->pdf = new ConfigHeaderRapportSortiDepot('L','mm','A4');
      $this->pdf->AliasNbPages();
      $this->pdf->SetFont('Helvetica','B',12);
      $this->pdf->SetMargins(5,5,5);
      $this->pdf->AddPage();

      $this->pdf->Cell(287,5,utf8_decode('RAPPORT JOURNAL DE SORTI '.$depotInfo->nom),0,1,'C');
      $this->pdf->SetFont('Helvetica','B',8);
      $this->pdf->Cell(287,5,'Date : '.$dateRapport,0,1,'C');

      if(!$allArticle){
        $this->pdf->Cell(287,20,'AUCUN ARTICLE SELECTIONNER SUR LE RAPPORT',1,0,'C');
        $this->outPut();
      }


      //CREATION ENTETE TABLEAU
      $enteTableArticle = array();
      $DonneTableArticle = array();
      $DonneStockInitial = array();
      $DonneStockInitialVirtuel = array();
      $DonneApprovisionnement = array();
      $DonneApprovisionnementPv = array();
      $DonneApprovisionnementTotal = array();
      $LineEmptyNumFacture = array();
      $DonneApprovisionnementInterDepot = array();
      $DonneApprovisionnementInterDepotRecu = array();
      for($i = 0; $i < count($allArticle); $i++){
        //APPROVISIONNEMENT GENERAL
        $approGen = $this->approvisionnementsDetailModel->selectSum('qte')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        $approGenPv = $this->approvisionnementsDetailModel->selectSum('qte_pv')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        $pvPerdue = $this->pvPerdueHistoriqueModel->selectSum('qte_perdue')->join('g_interne_pv_perdue_historique_detail','g_interne_pv_perdue_historique.id = g_interne_pv_perdue_historique_detail.pv_historique_id')->Where('g_interne_pv_perdue_historique.date_historique',$dateRapport)->Where('g_interne_pv_perdue_historique.depots_id',$idDepot)->Where('g_interne_pv_perdue_historique_detail.articles_id',$allArticle[$i]->id)->find();

        // print_r($pvPerdue[0]->qte_perdue);
        // die();


        $approInterDepotExped = $this->approvisionnementsInterDepotDetailModel->selectSum('qte')->join('g_interne_approvisionnement_inter_depot','g_interne_approvisionnement_inter_depot.id = g_interne_approvisionnement_inter_depot_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_inter_depot_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement_inter_depot.depots_id_source",$idDepot)->Where('g_interne_approvisionnement_inter_depot_detail.is_validate',1)->Where('articles_id',$allArticle[$i]->id)->find();

        $approInterDepotRecu = $this->approvisionnementsInterDepotDetailModel->selectSum('qte')->join('g_interne_approvisionnement_inter_depot','g_interne_approvisionnement_inter_depot.id = g_interne_approvisionnement_inter_depot_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_inter_depot_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement_inter_depot.depots_id_dest",$idDepot)->Where('g_interne_approvisionnement_inter_depot_detail.is_validate',1)->Where('articles_id',$allArticle[$i]->id)->find();
        //GET QUANTITE INITIAL RESTANT EN STOCK HIER

        $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateRapport)->find();


        array_push($enteTableArticle,273/count($allArticle));
        array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
        array_push($DonneStockInitial,$stockInit ? $stockInit[0]->qte_stock : 0);
        array_push($DonneStockInitialVirtuel,$stockInit ? $stockInit[0]->qte_stock_virtuel : 0);
        array_push($DonneApprovisionnement,$approGen[0]->qte?$approGen[0]->qte:0);
        // array_push($DonneApprovisionnementPv,$approGenPv[0]->qte_pv?$approGenPv[0]->qte_pv:0);
        array_push($DonneApprovisionnementPv,$pvPerdue[0]->qte_perdue?$pvPerdue[0]->qte_perdue:0);

        array_push($DonneApprovisionnementTotal,$approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0);
        array_push($LineEmptyNumFacture,'');
        array_push($DonneApprovisionnementInterDepot,$approInterDepotExped[0]->qte?$approInterDepotExped[0]->qte:0);
        array_push($DonneApprovisionnementInterDepotRecu,$approInterDepotRecu[0]->qte?$approInterDepotRecu[0]->qte:0);


      }
      $this->pdf->SetWidths($enteTableArticle);

      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->Cell(14,5,'Produit',1,0,'L');
      $this->pdf->Row($DonneTableArticle);

      // DEBUT LISTE FACTURE JOURNALIERE

      // $this->pdf->Cell(14,5,'Facture',1,0,'L');
      $this->pdf->SetFillColor(96,96,96);
      $this->pdf->SetTextColor(255,255,255);
      $this->pdf->Cell(287,5,utf8_decode('TOUTES LES FACTURES LIVREES AUJOURD\'HUI'),0,1,'C',1);
      $this->pdf->SetTextColor(0,0,0);
      $this->pdf->SetWidths(array(273));
      // $this->pdf->Row(array(''));
      $this->pdf->SetFont('Helvetica','',6);
      $this->pdf->SetWidths($enteTableArticle);
      // $venteArray = array();
      foreach ($AchatsHistoLivre as $key => $value) {
        $achat = $this->commande->find($value->vente_id);
        $this->pdf->Cell(14,5,utf8_decode($achat->numero_commande),1,0,'L');
        $venteDetailArray = array();
        for($i = 0; $i < count($allArticle); $i++){
          $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$achat->id)->Where('articles_id',$allArticle[$i]->id)->Where('is_validate_livrer',1)->like('updated_at',$dateRapport,'after')->findAll();
            array_push($venteDetailArray,$detAchat?$detAchat[0]->qte_vendue:'-');
        }
        $this->pdf->Row($venteDetailArray);
      }

      if(count($AchatsHistoLivre) < 1){
        $this->pdf->Cell(287,5,utf8_decode('Pas de facture livrées aujord\'hui'),0,1,'C');
      }


      //FACTURES PAYES MAIS NON LIVRER : TOUTLES
      $this->pdf->SetFont('Helvetica','B',6);
      // $this->pdf->Cell(14,5,utf8_decode('Non livré'),1,0,'L');
      $this->pdf->SetFillColor(96,96,96);
      $this->pdf->SetTextColor(255,255,255);
      $this->pdf->Cell(287,5,utf8_decode('TOUTES LES FACTURES NON LIVREES'),0,1,'C',1);
      $this->pdf->SetTextColor(0,0,0);
      $this->pdf->SetWidths(array(273));
      // $this->pdf->SetWidths(array(273));
      // $this->pdf->Row(array(''));
      $this->pdf->SetFont('Helvetica','',6);
      $this->pdf->SetWidths($enteTableArticle);
      foreach ($AchatHistoroFacturePayeNonLivre as $key => $value) {
        $checkIfIsNonLivred = $this->commandesStatusHistoriqueModel->Where('vente_id',$value->id)->Where('status_vente_id',3)->find();
        // $achat = $this->commande->find($value->vente_id);
        // print_r($achat[0]->date_vente);
        // die();
        $this->pdf->SetTextColor(0,0,0);
        if(count($checkIfIsNonLivred) < 1){

          if($dateRapport !== explode(' ',$value->date_vente)[0]){
            $this->pdf->SetTextColor(255,0,0);
          }
          $this->pdf->Cell(14,5,utf8_decode($value->numero_commande),1,0,'L');
          $this->pdf->SetTextColor(0,0,0);

        }
        $venteDetailFactureNonPayeArray = array();
        for($i = 0; $i < count($allArticle); $i++){
          // print_r($checkIfIsNonLivred);
          if(count($checkIfIsNonLivred) < 1){
            //like('updated_at',$dateRapport,'after')-> condition to add for speicific date
            $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->id)->Where('articles_id',$allArticle[$i]->id)->findAll();
                array_push($venteDetailFactureNonPayeArray,$detAchat?$detAchat[0]->qte_vendue:'-');
          }
        }
        $this->pdf->Row($venteDetailFactureNonPayeArray);
      }

      if(count($AchatHistoroFacturePayeNonLivre) < 1){
        $this->pdf->Cell(287,5,utf8_decode('Pas de factures non livrées'),1,1,'C');
      }

      //FACTURE PAYE PMAIS LIVRER PARTILLEMENT ALORS LISTE DES ARTICLES NON LIVRER
      $this->pdf->SetFont('Helvetica','B',6);
      // $this->pdf->Cell(14,5,utf8_decode('Payé Partiel'),1,1,'L');
      $this->pdf->SetFillColor(96,96,96);
      $this->pdf->SetTextColor(255,255,255);
      $this->pdf->Cell(287,5,utf8_decode('TOUTES LES FACTURES PAYEES PARTIELLEMENT'),1,1,'C',1);
      $this->pdf->SetTextColor(0,0,0);
      $this->pdf->SetWidths(array(273));
      // $this->pdf->Row(array('TOUTLES LES FACTURES PAYES PARTIELLEMENT'));

      $this->pdf->SetFont('Helvetica','',6);
      $this->pdf->SetWidths($enteTableArticle);

      // $venteArray = array();
      foreach ($AchatLivrePartiellement as $key => $value) {
        // $achat = $this->commande->find($value->vente_id);
        $qteTotalPartiel = 0;
        $this->pdf->SetTextColor(0,0,0);
        if($dateRapport !== explode(' ',$value->date_vente)[0]){
          $this->pdf->SetTextColor(255,0,0);
        }
        $this->pdf->Cell(14,5,utf8_decode($value->numero_commande),1,0,'L');
        $this->pdf->SetTextColor(0,0,0);
        $venteDetailArray = array();
        for($i = 0; $i < count($allArticle); $i++){
          $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->id)->Where('articles_id',$allArticle[$i]->id)->where('is_validate_livrer',0)->findAll();
            array_push($venteDetailArray,$detAchat?$detAchat[0]->qte_vendue:'-');
        }
        $this->pdf->Row($venteDetailArray);
      }
      if(count($AchatLivrePartiellement) < 1){
        $this->pdf->Cell(287,5,utf8_decode('Pas de facture livrées partiellement'),1,1,'C');
      }


      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->Cell(14,5,'Stock Init R',1,0,'L');
      $this->pdf->Row($DonneStockInitial);

      $this->pdf->Cell(14,5,'Stock Init V',1,0,'L');
      $this->pdf->Row($DonneStockInitialVirtuel);

      $this->pdf->Cell(14,5,'Appro Bon',1,0,'L');
      $this->pdf->Row($DonneApprovisionnement);

      $this->pdf->Cell(14,5,'PV',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementPv);

      $this->pdf->Cell(14,5,'Appro Total',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementTotal);

      $this->pdf->Cell(14,5,'Appr Inter E',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementInterDepot);

      $this->pdf->Cell(14,5,'Appr Inter R',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementInterDepotRecu);


      // -====== CALCUL TOTAUX ==========//
      // -====== CALCUL TOTAUX ==========//
      // -====== CALCUL TOTAUX ==========//
      // -====== CALCUL TOTAUX ==========//


    //RECHERCHE QUANTITE TOTAL VENDU PAR ARTICLE
      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->SetWidths($enteTableArticle);
      $this->pdf->Cell(14,5,'Total vendu',1,0,'L');
      $TotalArticleVenduPayer =  array();

      for($i = 0; $i < count($allArticle); $i++){
        $qteTotal = 0;
        foreach ($AchatsHistoFacturePayeCalcul as $key => $value) {
          $detAchatPaye = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->vente_id)->Where('articles_id',$allArticle[$i]->id)->like('created_at',$dateRapport,'after')->findAll();
          if($detAchatPaye){
            $qteTotal = $qteTotal + $detAchatPaye[0]->qte_vendue;
          }else{
            $qteTotal = $qteTotal + 0;
          }
        }
        array_push($TotalArticleVenduPayer, $qteTotal);
      }
      $this->pdf->Row($TotalArticleVenduPayer);




      //RECHERCHE QUNATITE TOTAL LIVRER
        $this->pdf->SetFont('Helvetica','B',6);
        $this->pdf->SetWidths($enteTableArticle);
        $this->pdf->Cell(14,5,utf8_decode('Total livré'),1,0,'L');
        $TotalArticleVenduEtLivre = array();

        for($i = 0; $i < count($allArticle); $i++){
          $qteTotal = 0;
          foreach ($AchatsHistoLivre as $key => $value) {
            $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->vente_id)->Where('articles_id',$allArticle[$i]->id)->Where('is_validate_livrer',1)->like('updated_at',$dateRapport,'after')->findAll();
            if($detAchat){
              $qteTotal = $qteTotal + $detAchat[0]->qte_vendue;
            }else{
              $qteTotal = $qteTotal + 0;
            }
          }
          array_push($TotalArticleVenduEtLivre, $qteTotal);
        }
        $this->pdf->Row($TotalArticleVenduEtLivre);



      // //CALCUL TOTATL ARTICLE PAYE MAIS LIVRER PARTIELLEMENT
      // $qteTotalPayeMaisPasLivre = array();
      // for($i = 0; $i < count($allArticle); $i++){
      //   $qteTotal = 0;
      //   foreach ($AchatLivrePartiellement as $key => $value) {
      //       $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->vente_id)->Where('articles_id',$allArticle[$i]->id)->like('updated_at',$dateRapport,'after')->Where('is_validate_livrer',0)->findAll();
      //       if($detAchat){
      //         $qteTotal = $qteTotal + $detAchat[0]->qte_vendue;
      //       }else{
      //         $qteTotal = $qteTotal + 0;
      //       }
      //   }
      //   array_push($qteTotalPayeMaisPasLivre, $qteTotal);
      // }


        //AFFICHAGE NON LIVRER
        $this->pdf->SetFont('Helvetica','B',6);
        $this->pdf->SetWidths($enteTableArticle);
        $this->pdf->Cell(14,5,utf8_decode('Tot Non livré'),1,0,'L');
        $TotalArticleVenduNonLivrer =  array();

        for($i = 0; $i < count($allArticle); $i++){
          $qteTotal = 0;
          foreach ($AchatHistoroFacturePayeNonLivre as $key => $value) {
            $detAchatPaye = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->id)->Where('articles_id',$allArticle[$i]->id)->like('created_at',$dateRapport,'after')->findAll();
            if($detAchatPaye){
              $qteTotal = $qteTotal + $detAchatPaye[0]->qte_vendue;
            }else{
              $qteTotal = $qteTotal + 0;
            }
          }
          array_push($TotalArticleVenduNonLivrer, $qteTotal);
        }
        $this->pdf->Row($TotalArticleVenduNonLivrer);
        // $this->pdf->Row($TotalArticleVenduNonPayer);

        //AFFICHAGE TOTAL PAYER MAIS NON  LIVRER
        // $this->pdf->SetFont('Helvetica','B',6);
        // $this->pdf->SetWidths($enteTableArticle);
        // $this->pdf->Cell(14,5,utf8_decode('Tot Rst Part'),1,0,'L');
        // $this->pdf->Row($qteTotalPayeMaisPasLivre);


        //RESTE EN STOCK REEL ET VIRTUEL
        $this->pdf->SetWidths($enteTableArticle);

        $qteStockResteReelle = array();
        $qteStockResteVirtuel = array();

        $todayDate = Time::today();
        $m = strlen($todayDate->getMonth())==1?'0'.$todayDate->getMonth():$todayDate->getMonth();
        $d = strlen($todayDate->getDay())==1?'0'.$todayDate->getDay():$todayDate->getDay();
        $compareDate = $todayDate->getYear().'-'.$m.'-'.$d;

        for($i = 0; $i < count($allArticle); $i++){
          if($compareDate==$dateRapport){
            $stock = $this->stockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();
            array_push($qteStockResteReelle,$stock[0]->qte_stock);
            array_push($qteStockResteVirtuel,$stock[0]->qte_stock_virtuel);
          }else{
            $dateR = Time::parse($dateRapport);
            $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
            $dy = $dateR->getDay()+1;
            $dy = strlen($dy)==1?'0'. $dy:$dy;
            $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
            $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateR)->find();
            array_push($qteStockResteReelle,$stockInit ? $stockInit[0]->qte_stock : 0);
            array_push($qteStockResteVirtuel,$stockInit ? $stockInit[0]->qte_stock_virtuel : 0);
          }
        }

        $this->pdf->SetFont('Helvetica','B',6);
        $this->pdf->Cell(14,5,'Rst Stock R',1,0,'L');
        $this->pdf->Row($qteStockResteReelle);

        $this->pdf->Cell(14,5,'Rst Stock V',1,0,'L');
        $this->pdf->Row($qteStockResteVirtuel);



      $this->response->setHeader('Content-Type', 'application/pdf');
      // $this->pdf->Output('D',$dateRapport.'_Rapport_journal_de_sorti.pdf');
      $this->outPut();
    }

  public function rapport_finacier_journalier($dateRapport){

    $dataAllCaissiers = $this->usersModel->Where('roles_id',3)->findAll();

    $this->pdf = new TableFpdf('P','mm','A4');
    $this->pdf->AliasNbPages();
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    $dateR = Time::parse($dateRapport);
    $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
    $dyy = strlen($dateR->getDay())==1?'0'.$dateR->getDay():$dateR->getDay();

    $this->pdf->Cell(200,7,utf8_decode('RAPPORT FINANCIER JOURNALIER '),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->Cell(200,7,'Date : '.$dyy.'-'.$m.'-'. $dateR->getYear(),0,1,'C');

    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->SetWidths(array(30,20,25,25,25,25,25,25));
    $this->pdf->Row(array('Nom caissier','Vente','Encaissement Interne','Decaissement Interne','Encaissement Externe','Decaissement Externe','Montant Caisse Initial','Montant Caisse Actuel'));


    //VARIABLE POUR SITUATION TOTAL FINANCIERE
    $situationMontantTotalInitialHier = 0;
    $situationVenteTotaleJournaliere = 0;
    $situationMontantEncaissementExterne = 0;
    $situationMontantTotalEntre = 0;
    $situationMontantDecaissementExterne = 0;
    $situationMontantCaisseActuel = 0;


    $i =1;
    foreach ($dataAllCaissiers as $key => $value) {
      //REQUETTES
      $d = $dateRapport;
      //LES ACHATS
      $sommesAchatTotal = 0;
      $allVente = $this->commandesStatusHistoriqueModel->Where('status_vente_id',2)->Where('users_id',$value->id)->like('created_at',$d,'after')->findAll();
      foreach ($allVente as $key) {
        $detail = $this->commandesDetailModel->Where('vente_id',$key->vente_id)->findAll();
        $sommes= 0;
        foreach ($detail as $key => $valueAc) {
          $montant = ($valueAc->is_negotiate == 0 || $valueAc->is_negotiate == 1) ?$valueAc->qte_vendue * $valueAc->prix_unitaire:$valueAc->qte_vendue * $valueAc->prix_negociation;
          $sommes +=$montant;
        }
        $sommesAchatTotal+=$sommes;
      }

      //ENCAISSEMENT INTERNE : CAISSIER MAIN
      $sommesEncaissementInterne = $this->decaissementModel->selectSum('montant')->Where('users_id_dest',$value->id)->Where('date_decaissement',$d)->find();

      //DECAISSEMENT INTERNE : CAISSIER SECONDAIRE
      $sommesDecaissementInterne = $this->decaissementModel->selectSum('montant')->Where('users_id_from',$value->id)->Where('date_decaissement',$d)->find();

      //ENCAISSEMENT EXTERNE ; CAISSIER MAIN
      $sommesEncaissementExterne = $this->encaissementExterneModel->selectSum('montant_encaissement')->Where('users_id',$value->id)->Where('date_encaissement',$d)->find();

      //DECAISSEMENT INTERNE : CAISSIER MAIN
      $sommesDecaissementExterne = $this->decaissementExterneModel->selectSum('montant')->Where('users_id_from',$value->id)->Where('date_decaissement',$d)->find();


      //RESTE STOCK INITIAL
      $dateReste = Time::parse($dateRapport);
      $m = strlen($dateReste->getMonth())==1?'0'.$dateReste->getMonth():$dateReste->getMonth();
      $dy = $dateReste->getDay()-1;
      $dy = strlen($dy)==1?'0'. $dy:$dy;
      $dateReste = $dateReste->getYear().'-'.$m.'-'.$dy;

      $dataCaisseMontant = self::$caisseModel->Where('users_id',$value->id)->find();
      $dataCaisseMontantResteHier = self::$clotureCaisseModel->Where('users_id',$value->id)->Where('date_cloture', $dateReste)->find();

      //IF DATE TODAY A DIFFERENT TO DATE RAPPORT SHOW CLOTURE MONTANT TO MONTANT TOTAL ACTUEL CAISSE
      $dataCaisseMontantResteHierActuel = self::$clotureCaisseModel->Where('users_id',$value->id)->Where('date_cloture', $d)->find();


      $chiffreAchat = round($sommesAchatTotal,2);
      $chiffreEncaissementInterne = $sommesEncaissementInterne[0]->montant?round($sommesEncaissementInterne[0]->montant,2):0;
      $chiffreDecaissementInterne = $sommesDecaissementInterne[0]->montant?round($sommesDecaissementInterne[0]->montant,2):0;
      $chiffreEncaissementExterne = $sommesEncaissementExterne[0]->montant_encaissement?round($sommesEncaissementExterne[0]->montant_encaissement,2):0;
      $chiffreDecaissementExterne = $sommesDecaissementExterne[0]->montant?round($sommesDecaissementExterne[0]->montant,2):0;
      $this->pdf->Row(array(
        utf8_decode(strtoupper($value->nom)).' '.utf8_decode(strtoupper($value->prenom)),
        $chiffreAchat,
        $chiffreEncaissementInterne,
        $chiffreDecaissementInterne,
        $chiffreEncaissementExterne,
        $chiffreDecaissementExterne,
        $dataCaisseMontantResteHier?$dataCaisseMontantResteHier[0]->montant:0,
        round($dataCaisseMontant?$dataCaisseMontant[0]->montant:0, 2)
      ));

      // $idCaissierPrincipal = $value->is_main = 1 ? $value->id : 0;
      //CALCUL POUR SITUTATION TOTAL DE LA CAISSE
      if($value->is_main==1){
        $situationMontantTotalInitialHier += $dataCaisseMontantResteHier?$dataCaisseMontantResteHier[0]->montant:0;
        $situationVenteTotaleJournaliere += $chiffreAchat + $chiffreEncaissementInterne;
        $situationMontantEncaissementExterne += $chiffreEncaissementExterne;
        $situationMontantTotalEntre += $chiffreAchat + $chiffreEncaissementInterne + $chiffreEncaissementExterne;
        $situationMontantDecaissementExterne += $chiffreDecaissementExterne;

        $dateToday = Time::today();
        $mois = strlen($dateToday->getMonth())==1?'0'.$dateToday->getMonth():$dateToday->getMonth();
        $dayss = strlen($dateToday->getDay())==1?'0'. $dateToday->getDay():$dateToday->getDay();
        $dateToday = $dateToday->getYear().'-'.$mois.'-'.$dayss;

        if($dateToday===$d){
          $situationMontantCaisseActuel += $dataCaisseMontant[0]->montant?$dataCaisseMontant[0]->montant:0;
        }else{
          $situationMontantCaisseActuel += $dataCaisseMontantResteHierActuel?$dataCaisseMontantResteHierActuel[0]->montant:0;
        }

      }

    }
    $this->pdf->Ln();
    $this->pdf->SetFont('Helvetica','B',10);
    $this->pdf->Cell(200,7,' SITUATION CAISSE TOTALE ',0,1,'C');

    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->Cell(100,7,'Montant Initial Caisse : ',1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantTotalInitialHier, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Ventes Totales journalières : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationVenteTotaleJournaliere, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Encaissement Externe : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantEncaissementExterne, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Montant Total Entré : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantTotalEntre, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Montant Total Entré + Montant Initial Caisse : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantTotalInitialHier + $situationMontantTotalEntre, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Décaissement Externe : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantDecaissementExterne, 2).' USD',1,1,'L');

    $this->pdf->Cell(100,7,utf8_decode('Montant caisse Actuel (Final) : '),1,0,'L');
    $this->pdf->Cell(100,7,round($situationMontantCaisseActuel, 2).' USD',1,1,'L');

    $this->pdf->Ln();
    $this->pdf->SetFont('Helvetica','B',10);
    $this->pdf->Cell(200,7,'DETAIL ENCAISSEMENT EXTERNE ',0,1,'C');


    $conditionDate =['date_encaissement'=> $dateRapport];

    $dataEncaissementExterne = $this->encaissementExterneModel->select("id,users_id,date_encaissement,motif,created_at,montant_encaissement")->Where($conditionDate)->orderBy('id','DESC')->findAll();
    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->SetWidths(array(50,50,50,50));
    $this->pdf->Row(array('DATE','CAISSIER','MONTANT','MOTIF SOURCE'));
    foreach ($dataEncaissementExterne as $key => $value) {
      // code...
    $this->pdf->Row(array($value->date_encaissement,utf8_decode($value->users_id->nom.' '.$value->users_id->prenom),$value->montant_encaissement.' USD',utf8_decode($value->motif)));

    }

    $this->pdf->Ln();
    $this->pdf->SetFont('Helvetica','B',10);
    $this->pdf->Cell(200,7,'DETAIL DECAISSEMENT EXTERNE ',0,1,'C');
    $conditionDateDec =['date_decaissement'=> $dateRapport];
    $dataDecaissement = $this->decaissementExterneModel->Where($conditionDateDec)->orderBy('id','DESC')->findAll();

    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->SetWidths(array(40,40,40,40,40));
    $this->pdf->Row(array('DATE','CAISSIER','MONTANT','DESTINATION','NOTE'));

    foreach ($dataDecaissement as $key => $value) {
      // code...
    $this->pdf->Row(array($value->date_decaissement,utf8_decode($value->users_id_from->nom.' '.$value->users_id_from->prenom),$value->montant.' USD',utf8_decode($value->destination),utf8_decode($value->note)));

    }

    $this->outPut();
    $this->response->setHeader('Content-Type', 'application/pdf');
    // $this->pdf->Output('D',$dateRapport.'_Rapport_journalier_financier.pdf');
  }

  public function rapport_stock_general($dateRapport){
    $allArticle = $this->articlesModel->Where('is_show_on_rapport',1)->findAll();

    $this->pdf = new TableFpdf('P','mm','A4');
    $this->pdf->AliasNbPages();
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    $dateR = Time::parse($dateRapport);
    $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
    $dyy = strlen($dateR->getDay())==1?'0'.$dateR->getDay():$dateR->getDay();

    $this->pdf->Cell(200,7,utf8_decode('RAPPORT STOCK GENERAL'),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->Cell(200,7,'Date : '.$dyy.'-'.$m.'-'. $dateR->getYear(),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->Ln(5);
    $this->pdf->SetWidths(array(45,15,15,15,15,15,15,15,15,15,20));
    $this->pdf->Row(array('Designation',utf8_decode('Stock Initial Réelle'),utf8_decode('Stock Initial Virtuelle'),utf8_decode('Entrée Qte Bonne'),utf8_decode('Entrée Qte PV'),utf8_decode('Entrée Qte Totale'),utf8_decode('Sorti (Total Vendu)'),utf8_decode('Sorti (Total livré)'),utf8_decode('Stock Final Réelle'),utf8_decode('Stock Final Virtuelle'),utf8_decode('Observation')));
    $this->pdf->SetFont('Helvetica','',6);
    foreach ($allArticle as $key => $value) {
      // code... SI
      $stockInit = $this->clotureStockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->Where('date_cloture',$dateRapport)->find();

      $stockInitVirtuel = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateRapport)->find();

      //code Entree
      $approGenBonne = $this->approvisionnementsDetailModel->selectSum('qte')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where('articles_id',$value->id)->find();

      $approGenPv = $this->approvisionnementsDetailModel->selectSum('qte_pv')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where('articles_id',$value->id)->find();

      $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where('articles_id',$value->id)->find();

      //code pour sorti
      $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',2)->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->findAll();

      $AchatsHistoLivre = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',3)->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->groupBy('g_interne_vente_historique_status.vente_id')->findAll();


      $qteTotalVendu = 0;
      foreach ($AchatsHisto as $key) {
        $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$key->vente_id)->Where('articles_id',$value->id)->like('created_at',$dateRapport,'after')->findAll();
        if($detAchat){
          $qteTotalVendu += $detAchat[0]->qte_vendue;
        }
      }

      $qteTotalLivre = 0;
      foreach ($AchatsHistoLivre as $key) {
        $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$key->vente_id)->Where('articles_id',$value->id)->Where('is_validate_livrer',1)->like('updated_at',$dateRapport,'after')->findAll();
        if($detAchat){
          $qteTotalLivre += $detAchat[0]->qte_vendue;
        }
      }

      //RESTE EN Stock
      $todayDate = Time::today();
      $m = strlen($todayDate->getMonth())==1?'0'.$todayDate->getMonth():$todayDate->getMonth();
      $myday = strlen($todayDate->getDay())==1?'0'.$todayDate->getDay():$todayDate->getDay();
      $compareDate = $todayDate->getYear().'-'.$m.'-'.$myday;

      $qteResteEnStockReelle = 0;
      $qteResteEnStockVirtuelle = 0;

        if($compareDate==$dateRapport){
          // echo 'Here';
          $stockVirtuelle = $this->stockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->find();
          $stock = $this->stockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->find();
          $qteResteEnStockReelle = $stock[0]->qte_stock ? $stock[0]->qte_stock:0;
          $qteResteEnStockVirtuelle = $stockVirtuelle[0]->qte_stock_virtuel ? $stockVirtuelle[0]->qte_stock_virtuel:0;

          // echo 'here </br>';
        }else{
          // echo 'Here Too';
          $dateR = Time::parse($dateRapport);
          $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
          $dy = $dateR->getDay()+1;
          $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
          $stockInitCloture = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateR)->find();
          $stockInitClotureReelle = $this->clotureStockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->Where('date_cloture',$dateR)->find();

          // echo '<pre>';
          // print_r($dateR);
          // die();
          $qteResteEnStockReelle = $stockInitClotureReelle[0]->qte_stock? $stockInitClotureReelle[0]->qte_stock:0;
          $qteResteEnStockVirtuelle = $stockInitCloture[0]->qte_stock_virtuel? $stockInitCloture[0]->qte_stock_virtuel:0;

          // echo 'here too </br>';
        }


      $this->pdf->Row(array(
            utf8_decode(strtoupper($value->nom_article)),
            $stockInit[0]->qte_stock?$stockInit[0]->qte_stock:0,
            $stockInitVirtuel[0]->qte_stock_virtuel?$stockInitVirtuel[0]->qte_stock_virtuel:0,
            $approGenBonne[0]->qte?$approGenBonne[0]->qte:0,
            $approGenPv[0]->qte_pv?$approGenPv[0]->qte_pv:0,
            $approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0,
            $qteTotalVendu,
            $qteTotalLivre,
            $qteResteEnStockReelle,
            $qteResteEnStockVirtuelle,
            '-'));
    }

    // $stockInit = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',1)->Where('date_cloture','2021-01-23')->find();
    // echo '<pre>';
    // print_r($stockInit);
    // die();



    // $this->outPut();
    $this->response->setHeader('Content-Type', 'application/pdf');
    $this->pdf->Output('D',$dateRapport.'_Rapport_stock_general.pdf');
  }

  public function rapport_stock_entree_sortie_interval($idDepot,$dateDebut, $dateFin){
    $depotInfo = $this->depotModel->find($idDepot);
    $allArticle = $this->articlesModel->Where('is_show_on_rapport',1)->findAll();

    $this->pdf = new TableFpdf('P','mm','A4');
    $this->pdf->AliasNbPages();
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    $dateR = Time::parse($dateDebut);
    $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
    $dyy = strlen($dateR->getDay())==1?'0'.$dateR->getDay():$dateR->getDay();

    $this->pdf->Cell(200,7,utf8_decode('RAPPORT STOCK ENTREE - SORTIES'),0,1,'C');
    $this->pdf->Cell(200,7,utf8_decode($depotInfo->nom),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',12);
    // $this->pdf->Cell(200,7,'Date : '.$dyy.'-'.$m.'-'. $dateR->getYear(),0,1,'C');
    $this->pdf->Cell(200,7,'DU : '.$dateDebut.' AU '.$dateFin,0,1,'C');
    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->Ln(5);
    $this->pdf->SetWidths(array(45,15,15,15,15,15,15,15));
    $this->pdf->Row(array('Designation',utf8_decode('Stock Initial Réel'),utf8_decode('Stock Initial Virtuel'),utf8_decode('Total Entrée'),utf8_decode('Total Sorties virtuels '),utf8_decode('Total Sorties Réels'),utf8_decode('Diff Virtuelles'),utf8_decode('Diff Réelles')));
    $this->pdf->SetFont('Helvetica','',6);
    foreach ($allArticle as $key => $value) {
      // code... SI
      $stockInit = $this->clotureStockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->Where('date_cloture',$dateDebut)->Where('depot_id',$idDepot)->find();

      $stockInitVirtuel = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateDebut)->Where('depot_id',$idDepot)->find();
      //
      //Total Entree Stock
      $conditionIntevalDate = ['g_interne_approvisionnement.date_approvisionnement >='=>$dateDebut,'g_interne_approvisionnement.date_approvisionnement <='=>$dateFin];
      $approGenBonne = $this->approvisionnementsDetailModel->selectSum('qte')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->Where($conditionIntevalDate)->Where('depots_id',$idDepot)->Where('articles_id',$value->id)->find();

      // $approGenPv = $this->approvisionnementsDetailModel->selectSum('qte_pv')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateDebut,'after')->Where('articles_id',$value->id)->find();
      //
      // $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateDebut,'after')->Where('articles_id',$value->id)->find();
      //
      // //code pour sorti virtuelles
      $conditionIntevalDateSorti = ['g_interne_vente_historique_status.created_at >='=>$dateDebut,'g_interne_vente_historique_status.created_at <='=>$dateFin];
      $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',2)->Where('g_interne_vente.depots_id',$idDepot)->Where($conditionIntevalDateSorti)->findAll();

      // //code pour sorti reels
      $AchatsHistoLivre = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',3)->Where('g_interne_vente.depots_id',$idDepot)->Where($conditionIntevalDateSorti)->groupBy('g_interne_vente_historique_status.vente_id')->findAll();

      // echo count($AchatsHistoLivre);
      // die();

      //
      $qteTotalVendu = 0;
      foreach ($AchatsHisto as $key) {
        $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$key->vente_id)->Where('articles_id',$value->id)->findAll();
        if($detAchat){
          $qteTotalVendu += $detAchat[0]->qte_vendue;
        }
      }
      //
      $qteTotalLivre = 0;
      foreach ($AchatsHistoLivre as $key) {
        $conditionIntevalDateSortiLivre = ['updated_at >='=>$dateDebut,'updated_at <='=>$dateFin];
        $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$key->vente_id)->Where('articles_id',$value->id)->Where('is_validate_livrer',1)->Where($conditionIntevalDateSortiLivre)->findAll();
        if($detAchat){
          $qteTotalLivre += $detAchat[0]->qte_vendue;
        }
      }
      //
      // //RESTE EN Stock
      // $todayDate = Time::today();
      // $m = strlen($todayDate->getMonth())==1?'0'.$todayDate->getMonth():$todayDate->getMonth();
      // $myday = strlen($todayDate->getDay())==1?'0'.$todayDate->getDay():$todayDate->getDay();
      // $compareDate = $todayDate->getYear().'-'.$m.'-'.$myday;
      //
      // $qteResteEnStockReelle = 0;
      // $qteResteEnStockVirtuelle = 0;
      //
      //   if($compareDate==$dateRapport){
      //     // echo 'Here';
      //     $stockVirtuelle = $this->stockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->find();
      //     $stock = $this->stockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->find();
      //     $qteResteEnStockReelle = $stock[0]->qte_stock ? $stock[0]->qte_stock:0;
      //     $qteResteEnStockVirtuelle = $stockVirtuelle[0]->qte_stock_virtuel ? $stockVirtuelle[0]->qte_stock_virtuel:0;
      //
      //     // echo 'here </br>';
      //   }else{
      //     // echo 'Here Too';
      //     $dateR = Time::parse($dateRapport);
      //     $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
      //     $dy = $dateR->getDay()+1;
      //     $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
      //     $stockInitCloture = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateR)->find();
      //     $stockInitClotureReelle = $this->clotureStockModel->selectSum('qte_stock')->Where('articles_id',$value->id)->Where('date_cloture',$dateR)->find();
      //
      //     // echo '<pre>';
      //     // print_r($dateR);
      //     // die();
      //     $qteResteEnStockReelle = $stockInitClotureReelle[0]->qte_stock? $stockInitClotureReelle[0]->qte_stock:0;
      //     $qteResteEnStockVirtuelle = $stockInitCloture[0]->qte_stock_virtuel? $stockInitCloture[0]->qte_stock_virtuel:0;
      //
      //     // echo 'here too </br>';
      //   }
      //
      $stockInitReel = $stockInit[0]->qte_stock?$stockInit[0]->qte_stock:0;
      $stockInitVirtuel = $stockInitVirtuel[0]->qte_stock_virtuel?$stockInitVirtuel[0]->qte_stock_virtuel:0;
      $entre = $approGenBonne[0]->qte?$approGenBonne[0]->qte:0;
      $diffVirtuel =($stockInitReel+$entre)-$qteTotalVendu;
      $diffReel = ($stockInitVirtuel+$entre)-$qteTotalLivre;

      $this->pdf->Row(array(
            utf8_decode(strtoupper($value->nom_article)),
            $stockInitReel,
            $stockInitVirtuel,
            $entre,
            $qteTotalVendu,
            $qteTotalLivre,
            $diffVirtuel,
            $diffReel,
            // $stockInit[0]->qte_stock?$stockInit[0]->qte_stock:0,
            // $stockInitVirtuel[0]->qte_stock_virtuel?$stockInitVirtuel[0]->qte_stock_virtuel:0,

            // $approGenPv[0]->qte_pv?$approGenPv[0]->qte_pv:0,
            // $approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0,
            // $qteTotalVendu,
            // $qteTotalLivre,
            // $qteResteEnStockReelle,
            // $qteResteEnStockVirtuelle,
            ));
    }

    // $stockInit = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',1)->Where('date_cloture','2021-01-23')->find();
    // echo '<pre>';
    // print_r($stockInit);
    // die();



    // $this->outPut();
    $this->response->setHeader('Content-Type', 'application/pdf');
    // $this->pdf->Output('D',$dateDebut.'_Rapport_stock_general.pdf');
    $this->outPut();
  }

  public function rapport_approvisionnemnt_interval($idDepot,$dateDebut, $dateFin){
    $depotInfo = $this->depotModel->find($idDepot);
    $allArticle = $this->articlesModel->Where('is_show_on_rapport',1)->findAll();

    $this->pdf = new ConfigHeaderRapportSortiDepot('L','mm','A4');
    $this->pdf->AliasNbPages();
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    $this->pdf->Cell(287,5,utf8_decode('RAPPORT D\'APPROVISIONNEMENT'),0,1,'C');
    $this->pdf->Cell(287,5,utf8_decode($depotInfo->nom),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',8);
    $this->pdf->Cell(287,5,'DU : '.$dateDebut.' AU '.$dateFin,0,1,'C');

    if(!$allArticle){
      $this->pdf->Cell(287,20,'AUCUN ARTICLE SELECTIONNER SUR LE RAPPORT',1,0,'C');
      $this->outPut();
    }

    $enteTableArticle = array();
    $DonneTableArticle = array();
    $DonneTotalApprovisionnementTotal =  array();
    for($i = 0; $i < count($allArticle); $i++){

      $conditionIntevalDateMain = ['g_interne_approvisionnement.date_approvisionnement >='=>$dateDebut,'g_interne_approvisionnement.date_approvisionnement <='=>$dateFin];
      $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->Where($conditionIntevalDateMain)->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

      array_push($enteTableArticle,273/count($allArticle));
      array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
      array_push($DonneTotalApprovisionnementTotal,$approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0);
    }
    $this->pdf->SetWidths($enteTableArticle);
    $this->pdf->SetFont('Helvetica','B',6);
    $this->pdf->Cell(14,5,'Produit',1,0,'L');
    $this->pdf->Row($DonneTableArticle);


    $this->pdf->SetFillColor(96,96,96);
    $this->pdf->SetTextColor(255,255,255);
    $this->pdf->Cell(287,5,utf8_decode('TOUS LES APPROVISIONNEMENT DU '.$dateDebut.' AU '.$dateFin),0,1,'C',1);
    $this->pdf->SetTextColor(0,0,0);
    $this->pdf->SetWidths(array(273));
    // $this->pdf->Row(array(''));
    $this->pdf->SetFont('Helvetica','',6);
    $this->pdf->SetWidths($enteTableArticle);
    // $venteArray = array();
    $conditionIntevalDate = ['date_approvisionnement >='=>$dateDebut,'date_approvisionnement <='=>$dateFin];
    $approDate = $this->approvisionnementModel->where($conditionIntevalDate)->Where('depots_id',$idDepot)->groupBy('date_approvisionnement')->findAll();

    foreach ($approDate as $key => $value) {
      // code...
      $ApprovisionnementDetailArray = array();
      $this->pdf->Cell(14,5,utf8_decode($value->date_approvisionnement),1,0,'L');
        for($i = 0; $i < count($allArticle); $i++){
          $detApprov = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->Where('depots_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->like('g_interne_approvisionnement_detail.created_at',$value->date_approvisionnement,'after')->findAll();
            array_push($ApprovisionnementDetailArray,$detApprov?$detApprov[0]->qte_total:'-');
        }
        $this->pdf->Row($ApprovisionnementDetailArray);

    }

    $this->pdf->Cell(14,5,'Total',1,0,'L');
    $this->pdf->Row($DonneTotalApprovisionnementTotal);

    // foreach ($AchatsHistoLivre as $key => $value) {
    //   $achat = $this->commande->find($value->vente_id);
    //   $this->pdf->Cell(14,5,utf8_decode($achat->numero_commande),1,0,'L');
    //   $venteDetailArray = array();
    //   for($i = 0; $i < count($allArticle); $i++){
    //     $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$achat->id)->Where('articles_id',$allArticle[$i]->id)->Where('is_validate_livrer',1)->like('updated_at',$dateRapport,'after')->findAll();
    //       array_push($venteDetailArray,$detAchat?$detAchat[0]->qte_vendue:'-');
    //   }
    //   $this->pdf->Row($venteDetailArray);
    // }

    $this->response->setHeader('Content-Type', 'application/pdf');
    // $this->pdf->Output('D',$dateRapport.'_Rapport_journal_de_sorti.pdf');
    $this->outPut();
  }
}
