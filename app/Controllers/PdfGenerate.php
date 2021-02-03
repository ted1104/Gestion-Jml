<?php

namespace App\Controllers;
use FPDF;
use App\Models\CommandesModel;
use App\Models\StDepotModel;
use App\Models\ArticlesModel;
use App\Models\CommandesDetailModel;
use App\Models\CommandesStatusHistoriqueModel;
use App\Models\ApprovisionnementsDetailModel;
use App\Models\StockModel;
use App\Models\ClotureStockModel;
use App\Models\UsersModel;
use CodeIgniter\I18n\Time;
use App\Models\DecaissementModel;
use App\Models\EncaissementExterneModel;
use App\Models\DecaissementExterneModel;
use App\Models\CaisseModel;
use App\Models\ClotureCaisseModel;



class PdfGenerate extends BaseController {
  protected $pdf;
  protected $commande;
  protected $depotModel = null;
  protected $articlesModel = null;
  protected $commandesDetailModel = null;
  protected $commandesStatusHistoriqueModel = null;
  protected $approvisionnementsDetailModel = null;
  protected $stockModel = null;
  protected $clotureStockModel = null;
  protected $usersModel = null;
  protected $decaissementModel  = null;
  protected $encaissementExterneModel = null;
  protected $decaissementExterneModel = null;
  protected static $caisseModel = null;
  protected static $clotureCaisseModel = null;





  public function __construct(){
    $this->pdf = new FPDF();

    $this->commande = new CommandesModel();
    $this->depotModel = new StDepotModel();
    $this->articlesModel = new ArticlesModel();
    $this->commandesDetailModel = new CommandesDetailModel();
    $this->commandesStatusHistoriqueModel = new CommandesStatusHistoriqueModel();
    $this->approvisionnementsDetailModel = new ApprovisionnementsDetailModel();
    $this->stockModel = new StockModel();
    $this->clotureStockModel = new ClotureStockModel();
    $this->usersModel = new UsersModel();
    $this->decaissementModel = new DecaissementModel();
    $this->encaissementExterneModel = new EncaissementExterneModel();
    $this->decaissementExterneModel = new DecaissementExterneModel();
    self::$caisseModel = new CaisseModel();
    self::$clotureCaisseModel = new ClotureCaisseModel();



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
    $this->pdf->Ln();

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
      $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->Where('g_interne_vente_historique_status.status_vente_id',3)->Where('depots_id',$idDepot)->findAll();

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
      $DonneApprovisionnement = array();
      $DonneApprovisionnementPv = array();
      $DonneApprovisionnementTotal = array();
      $LineEmptyNumFacture = array();
      for($i = 0; $i < count($allArticle); $i++){
        //APPROVISIONNEMENT GENERAL
        $approGen = $this->approvisionnementsDetailModel->selectSum('qte')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        $approGenPv = $this->approvisionnementsDetailModel->selectSum('qte_pv')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        //GET QUANTITE INITIAL RESTANT EN STOCK HIER

        $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateRapport)->find();


        // echo "<pre>";
        // print_r($approGen[0]->qte);
        // print_r($allArticle[$i]->id);
        // echo "</pre>";
        // exit();

        array_push($enteTableArticle,273/count($allArticle));
        array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
        array_push($DonneStockInitial,$stockInit ? $stockInit[0]->qte_stock_virtuel : 0);
        array_push($DonneApprovisionnement,$approGen[0]->qte?$approGen[0]->qte:0);
        array_push($DonneApprovisionnementPv,$approGenPv[0]->qte_pv?$approGenPv[0]->qte_pv:0);
        array_push($DonneApprovisionnementTotal,$approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0);
        array_push($LineEmptyNumFacture,'');
      }
      $this->pdf->SetWidths($enteTableArticle);

      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->Cell(14,5,'Produit',1,0,'L');
      $this->pdf->Row($DonneTableArticle);

      $this->pdf->Cell(14,5,'Stock Init',1,0,'L');
      $this->pdf->Row($DonneStockInitial);

      $this->pdf->Cell(14,5,'Appro Bon',1,0,'L');
      $this->pdf->Row($DonneApprovisionnement);

      $this->pdf->Cell(14,5,'PV',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementPv);

      $this->pdf->Cell(14,5,'Appro Total',1,0,'L');
      $this->pdf->Row($DonneApprovisionnementTotal);

      $this->pdf->Cell(14,5,'Facture',1,0,'L');
      $this->pdf->SetWidths(array(273));
      $this->pdf->Row(array(''));
      $this->pdf->SetFont('Helvetica','',6);
      $this->pdf->SetWidths($enteTableArticle);
      // $venteArray = array();
      foreach ($AchatsHisto as $key => $value) {
        $achat = $this->commande->find($value->vente_id);
        $this->pdf->Cell(14,5,utf8_decode($achat->numero_commande),1,0,'L');
        $venteDetailArray = array();
        for($i = 0; $i < count($allArticle); $i++){
          $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$achat->id)->Where('articles_id',$allArticle[$i]->id)->findAll();
            array_push($venteDetailArray,$detAchat?$detAchat[0]->qte_vendue:'-');
        }
        $this->pdf->Row($venteDetailArray);
      }

    //RECHERCHE MONTANT TOTAL PAR ARTICLE
      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->SetWidths($enteTableArticle);
      $this->pdf->Cell(14,5,'Total vendu',1,0,'L');
      $TotalArticleVendu =  array();
      for($i = 0; $i < count($allArticle); $i++){
        $qteTotal = 0;
        foreach ($AchatsHisto as $key => $value) {
          $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$value->vente_id)->Where('articles_id',$allArticle[$i]->id)->findAll();
          if($detAchat){
            $qteTotal = $qteTotal + $detAchat[0]->qte_vendue;
          }else{
            $qteTotal = $qteTotal + 0;
          }
        }
        array_push($TotalArticleVendu, $qteTotal);
      }

      $this->pdf->Row($TotalArticleVendu);

      //RESTE EN Stock
      $this->pdf->SetWidths($enteTableArticle);
      $this->pdf->Cell(14,5,'Reste Stock',1,0,'L');
      $qteStockReste = array();

      $todayDate = Time::today();
      $m = strlen($todayDate->getMonth())==1?'0'.$todayDate->getMonth():$todayDate->getMonth();
      $d = strlen($todayDate->getDay())==1?'0'.$todayDate->getDay():$todayDate->getDay();
      $compareDate = $todayDate->getYear().'-'.$m.'-'.$d;

      for($i = 0; $i < count($allArticle); $i++){
        if($compareDate==$dateRapport){
          $stock = $this->stockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();
          array_push($qteStockReste,$stock[0]->qte_stock_virtuel);
        }else{
          $dateR = Time::parse($dateRapport);
          $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
          $dy = $dateR->getDay()+1;
          $dy = strlen($dy)==1?'0'. $dy:$dy;
          $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
          $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateR)->find();
          array_push($qteStockReste,$stockInit ? $stockInit[0]->qte_stock_virtuel : 0);
        }

      }
      $this->pdf->Row($qteStockReste);
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

      $this->pdf->SetFont('Helvetica','B',10);
      $this->pdf->Cell(200,7,$i++.'. '.utf8_decode(strtoupper($value->nom).' '.strtoupper($value->prenom)),0,1,'L');
      $this->pdf->SetFont('Helvetica','B',8);
      $this->pdf->SetWidths(array(40,40,40,40,40));
      $this->pdf->Row(array('Vente','Encaissement Interne','Decaissement Interne','Encaissement Externe','Decaissement Externe'));

      $chiffreAchat = round($sommesAchatTotal,2);
      $chiffreEncaissementInterne = $sommesEncaissementInterne[0]->montant?round($sommesEncaissementInterne[0]->montant,2):0;
      $chiffreDecaissementInterne = $sommesDecaissementInterne[0]->montant?round($sommesDecaissementInterne[0]->montant,2):0;
      $chiffreEncaissementExterne = $sommesEncaissementExterne[0]->montant_encaissement?round($sommesEncaissementExterne[0]->montant_encaissement,2):0;
      $chiffreDecaissementExterne = $sommesDecaissementExterne[0]->montant?round($sommesDecaissementExterne[0]->montant,2):0;
      $this->pdf->Row(array(
        $chiffreAchat,
        $chiffreEncaissementInterne,
        $chiffreDecaissementInterne,
        $chiffreEncaissementExterne,
        $chiffreDecaissementExterne
      ));

      $this->pdf->Cell(200,7,utf8_decode('Montant Caisse Initial : '.($dataCaisseMontantResteHier[0]->montant?$dataCaisseMontantResteHier[0]->montant:0).' USD'),1,1,'L');
      if($value->is_main == 1){
        $montantEntree = $chiffreAchat + $chiffreEncaissementInterne + $chiffreEncaissementExterne;
        $formule = 'Vente + Encaissement Interne + Encaissement Externe - Decaissement Externe';
        $this->pdf->Cell(200,7,utf8_decode('Ventes Total journalière : '.round($chiffreAchat+$chiffreEncaissementInterne, 2).' USD'),1,1,'L');
        $this->pdf->Cell(200,7,utf8_decode('Encaissement Externe : '.round($chiffreEncaissementExterne, 2).' USD'),1,1,'L');
        $this->pdf->Cell(200,7,utf8_decode('Montant Total Entrée : '.round($montantEntree,2).' USD'),1,1,'L');
        $this->pdf->Cell(200,7,'Montant Total Sorti : '.round($chiffreDecaissementExterne, 2).' USD',1,1,'L');
      // $this->pdf->Cell(200,7,utf8_decode('Difference : Montant Total Entrée -  Montant Total Sorti : '.round($montantEntree-$chiffreDecaissementExterne, 2).' USD'),1,1,'L');

      }else{
        $montantReste = $chiffreAchat - $chiffreDecaissementInterne;
        $formule = 'Vente - Decaissement Interne';
      }

      $this->pdf->Cell(200,7,'Total caisse Actuel : '.round($dataCaisseMontant[0]->montant, 2).' USD',1,1,'L');

      // echo '<pre>';
      // print_r($value);
      $this->pdf->Ln(5);
    }
    $this->outPut();
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
    $this->pdf->SetWidths(array(50,15,15,15,15,20));
    $this->pdf->Row(array('Designation','Stock Initial',utf8_decode('Entrée'),utf8_decode('Sorti'),utf8_decode('Stock Final'),utf8_decode('Observation')));
    $this->pdf->SetFont('Helvetica','',6);
    foreach ($allArticle as $key => $value) {
      // code... SI
      $stockInit = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateRapport)->find();

      //code Entree
      $approGenTotal = $this->approvisionnementsDetailModel->selectSum('qte_total')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where('articles_id',$value->id)->find();

      //code pour sorti
      $AchatsHisto = $this->commandesStatusHistoriqueModel->join('g_interne_vente','g_interne_vente_historique_status.vente_id=g_interne_vente.id','left')->Where('g_interne_vente_historique_status.status_vente_id',3)->like('g_interne_vente_historique_status.created_at',$dateRapport,'after')->findAll();

      // echo '<pre>';
      // print_r(count($AchatsHisto));
      // die();
      $qteTotal = 0;
      foreach ($AchatsHisto as $key) {
        $detAchat = $this->commandesDetailModel->selectSum('qte_vendue')->Where('vente_id',$key->vente_id)->Where('articles_id',$value->id)->findAll();
        if($detAchat){
          $qteTotal += $detAchat[0]->qte_vendue;
        }
      }

      //RESTE EN Stock
      $todayDate = Time::today();
      $m = strlen($todayDate->getMonth())==1?'0'.$todayDate->getMonth():$todayDate->getMonth();
      $myday = strlen($todayDate->getDay())==1?'0'.$todayDate->getDay():$todayDate->getDay();
      $compareDate = $todayDate->getYear().'-'.$m.'-'.$myday;

      $qteResteEnStock = 0;

        if($compareDate==$dateRapport){
          // echo 'Here';
          $stock = $this->stockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->find();
          $qteResteEnStock = $stock[0]->qte_stock_virtuel ? $stock[0]->qte_stock_virtuel:0;

          // echo 'here </br>';
        }else{
          // echo 'Here Too';
          $dateR = Time::parse($dateRapport);
          $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
          $dy = $dateR->getDay()+1;
          $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
          $stockInitCloture = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',$value->id)->Where('date_cloture',$dateR)->find();

          // echo '<pre>';
          // print_r($dateR);
          // die();
          $qteResteEnStock = $stockInitCloture[0]->qte_stock_virtuel? $stockInitCloture[0]->qte_stock_virtuel:0;

          // echo 'here too </br>';
        }


      $this->pdf->Row(array(
            utf8_decode(strtoupper($value->nom_article)),
            $stockInit[0]->qte_stock_virtuel?$stockInit[0]->qte_stock_virtuel:0,
            $approGenTotal[0]->qte_total?$approGenTotal[0]->qte_total:0,
            $qteTotal,
            $qteResteEnStock,
            '-'));
    }

    // $stockInit = $this->clotureStockModel->selectSum('qte_stock_virtuel')->Where('articles_id',1)->Where('date_cloture','2021-01-23')->find();
    // echo '<pre>';
    // print_r($stockInit);
    // die();



    $this->outPut();
  }
}
