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
      $LineEmptyNumFacture = array();
      for($i = 0; $i < count($allArticle); $i++){
        //APPROVISIONNEMENT GENERAL
        $approGen = $this->approvisionnementsDetailModel->selectSum('qte')->join('g_interne_approvisionnement','g_interne_approvisionnement.id = g_interne_approvisionnement_detail.approvisionnement_id','left')->like('g_interne_approvisionnement_detail.created_at',$dateRapport,'after')->Where("g_interne_approvisionnement.depots_id",$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();

        //GET QUANTITE INITIAL RESTANT EN STOCK HIER

        $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateRapport)->find();


        // echo "<pre>";
        // print_r($approGen[0]->qte);
        // print_r($allArticle[$i]->id);
        // echo "</pre>";
        // exit();

        array_push($enteTableArticle,273/count($allArticle));
        array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
        array_push($DonneStockInitial,$stockInit ? $stockInit[0]->qte_stock : 0);
        array_push($DonneApprovisionnement,$approGen[0]->qte?$approGen[0]->qte:0);
        array_push($LineEmptyNumFacture,'');
      }
      $this->pdf->SetWidths($enteTableArticle);

      $this->pdf->SetFont('Helvetica','B',6);
      $this->pdf->Cell(14,5,'Produit',1,0,'L');
      $this->pdf->Row($DonneTableArticle);

      $this->pdf->Cell(14,5,'Stock Init',1,0,'L');
      $this->pdf->Row($DonneStockInitial);

      $this->pdf->Cell(14,5,'Appro',1,0,'L');
      $this->pdf->Row($DonneApprovisionnement);

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
          $detAchat = $this->commandesDetailModel->Where('vente_id',$achat->id)->Where('articles_id',$allArticle[$i]->id)->findAll();
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
          $detAchat = $this->commandesDetailModel->Where('vente_id',$value->vente_id)->Where('articles_id',$allArticle[$i]->id)->findAll();
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
      $compareDate = $todayDate->getYear().'-'.$m.'-'.$todayDate->getDay();

      for($i = 0; $i < count($allArticle); $i++){
        if($compareDate==$dateRapport){
          $stock = $this->stockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->find();
          array_push($qteStockReste,$stock[0]->qte_stock);
        }else{
          $dateR = Time::parse($dateRapport);
          $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();
          $dy = $dateR->getDay()+1;
          $dateR = $dateR->getYear().'-'.$m.'-'.$dy;
          $stockInit = $this->clotureStockModel->Where('depot_id',$idDepot)->Where('articles_id',$allArticle[$i]->id)->Where('date_cloture',$dateR)->find();
          array_push($qteStockReste,$stockInit ? $stockInit[0]->qte_stock : 0);
        }

      }
      $this->pdf->Row($qteStockReste);
      $this->outPut();
    }

  public function rapport_finacier_journalier($dateRapport){
    $dataAllCaissiers = $this->usersModel->Where('roles_id',3)->findAll();
    // echo '<pre>';
    // print_r($dataAllCaissiers);
    // die();


    $this->pdf = new TableFpdf('P','mm','A4');
    $this->pdf->AliasNbPages();
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    $dateR = Time::parse($dateRapport);
    $m = strlen($dateR->getMonth())==1?'0'.$dateR->getMonth():$dateR->getMonth();

    $this->pdf->Cell(200,7,utf8_decode('RAPPORT FINANCIER JOURNALIER '),0,1,'C');
    $this->pdf->SetFont('Helvetica','B',12);
    $this->pdf->Cell(200,7,'Date : '.$dateR->getDay().'-'.$m.'-'. $dateR->getYear(),0,1,'C');

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

      //   return [
      //   'achat' => round($sommesAchatTotal,2),
      //   'encaissementInterne' => $sommesEncaissementInterne[0]->montant?round($sommesEncaissementInterne[0]->montant,2):0,
      //   'decaissementInterne' => $sommesDecaissementInterne[0]->montant?round($sommesDecaissementInterne[0]->montant,2):0,
      //   'encaissementExterne' => $sommesEncaissementExterne[0]->montant_encaissement?round($sommesEncaissementExterne[0]->montant_encaissement,2):0,
      //   'decaissementExterne' => $sommesDecaissementExterne[0]->montant?round($sommesDecaissementExterne[0]->montant,2):0,
      //   'date' => $d
      // ];
      // code...
      $this->pdf->SetFont('Helvetica','B',10);
      $this->pdf->Cell(200,7,$i++.'. '.utf8_decode(strtoupper($value->nom).' '.strtoupper($value->prenom)),0,1,'L');
      $this->pdf->SetFont('Helvetica','B',8);
      $this->pdf->SetWidths(array(40,40,40,40,40));
      $this->pdf->Row(array('Achat','Encaissement Interne','Decaissement Interne','Encaissement Externe','Decaissement Externe'));

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
      if($value->is_main == 1){
        $montantReste = ($chiffreAchat + $chiffreEncaissementInterne + $chiffreEncaissementExterne) - $chiffreDecaissementExterne;
        $formule = 'Achat + Encaissement Interne + Encaissement Externe - Decaissement Externe';
      }else{
        $montantReste = $chiffreAchat - $chiffreDecaissementInterne;
        $formule = 'Achat - Decaissement Interne';
      }
      $this->pdf->Cell(200,7,'Formule : '.$formule,1,1,'L');
      $this->pdf->Cell(200,7,'Montant Reste : '.round($montantReste, 2).' USD',1,1,'L');

      // echo '<pre>';
      // print_r($value);
      $this->pdf->Ln(5);
    }





    $this->outPut();
  }
}
