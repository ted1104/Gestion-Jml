<?php

namespace App\Controllers;
use FPDF;
use App\Models\CommandesModel;
use App\Models\StDepotModel;
use App\Models\ArticlesModel;
use App\Models\CommandesDetailModel;



class PdfGenerate extends BaseController {
  protected $pdf;
  protected $commande;
  protected $depotModel = null;
  protected $articlesModel = null;
  protected $commandesDetailModel = null;



  public function __construct(){
    $this->pdf = new FPDF();

    $this->commande = new CommandesModel();
    $this->depotModel = new StDepotModel();
    $this->articlesModel = new ArticlesModel();
    $this->commandesDetailModel = new CommandesDetailModel();


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
  $Achats = $this->commande->Where('date_vente',$dateRapport)->Where('depots_id',$idDepot)->findAll();
  // $data = $this->commande->find($code);
  // echo "<pre>";
  // print_r($Achats);
  // echo "</pre>";
  // exit();
  $this->pdf = new TableFpdf('L','mm','A4');
  $this->pdf->SetFont('Helvetica','B',8);
  $this->pdf->SetMargins(5,5,5);
  $this->pdf->AddPage();

  $this->pdf->Cell(287,5,utf8_decode('RAPPORT JOURNAL DE SORTI '.$depotInfo->nom),0,1,'C');
  $this->pdf->Cell(287,5,'Date : '.$dateRapport,0,1,'C');


  //CREATION ENTETE TABLEAU
  $enteTableArticle = array();
  $DonneTableArticle = array();
  $DonneStockInitial = array();
  $DonneApprovisionnement = array();
  $LineEmptyNumFacture = array();
  for($i = 0; $i < count($allArticle); $i++){
    array_push($enteTableArticle,275/count($allArticle));
    array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
    array_push($DonneStockInitial,0);
    array_push($DonneApprovisionnement,0);
    array_push($LineEmptyNumFacture,'');
  }
  $this->pdf->SetWidths($enteTableArticle);

  $this->pdf->SetFont('Helvetica','B',6);
  $this->pdf->Cell(12,5,'Produit',1,0,'L');
  $this->pdf->Row($DonneTableArticle);

  $this->pdf->Cell(12,5,'Stock Init',1,0,'L');
  $this->pdf->Row($DonneStockInitial);

  $this->pdf->Cell(12,5,'Appro',1,0,'L');
  $this->pdf->Row($DonneApprovisionnement);

  $this->pdf->Cell(12,5,'Facture',1,0,'L');
  $this->pdf->SetWidths(array(275));
  $this->pdf->Row(array(''));

  $this->pdf->SetWidths($enteTableArticle);
  // $venteArray = array();
  foreach ($Achats as $key => $value) {
    $this->pdf->Cell(12,5,utf8_decode($value->numero_commande),1,0,'L');
    $venteDetailArray = array();
    for($i = 0; $i < count($allArticle); $i++){
      $detAchat = $this->commandesDetailModel->Where('vente_id',$value->id)->Where('articles_id',$allArticle[$i]->id)->findAll();
      if($detAchat){
        array_push($venteDetailArray,$detAchat[0]->qte_vendue);
      }else{
        array_push($venteDetailArray,'-');
      }
    }
    $this->pdf->Row($venteDetailArray);
  }

//RECHERCHE MONTANT TOTAL PAR ARTICLE
  $this->pdf->SetWidths($enteTableArticle);
  $this->pdf->Cell(12,5,'Total',1,0,'L');
  $TotalArticleVendu =  array();
  for($i = 0; $i < count($allArticle); $i++){
    $qteTotal = 0;
    foreach ($Achats as $key => $value) {
      $detAchat = $this->commandesDetailModel->Where('vente_id',$value->id)->Where('articles_id',$allArticle[$i]->id)->findAll();
      if($detAchat){
        $qteTotal = $qteTotal + $detAchat[0]->qte_vendue;
      }else{
        $qteTotal = $qteTotal + 0;
      }
    }
    array_push($TotalArticleVendu, $qteTotal);
  }

  $this->pdf->Row($TotalArticleVendu);






  // $this->pdf->MulCell(287,5,'Date : '.$dateRapport,0,1,'C');
  // // $this->pdf->Ln();
  // $this->pdf->Cell(190,10,'Client : '.$data->nom_client,0,1,'C');
  // // $this->pdf->Ln();
  // $this->pdf->Cell(190,10,utf8_decode('Dépôt : '.$data->depots_id[0]->nom),0,1,'C');
  // $this->pdf->Cell(190,10,utf8_decode('Caissier : '.$data->payer_a[0]->nom.' '.$data->payer_a[0]->prenom),0,1,'C');
  // $this->pdf->Cell(190,10,utf8_decode('Montant Total : '.$data->logic_somme.' USD'),0,1,'C');
  // $this->pdf->SetFont('Helvetica','B',20);
  // $this->pdf->Cell(190,40,$data->numero_commande,0,1,'C');
  // $this->pdf->Ln();
  // $this->pdf->SetWidths(array(30,50,30,40));
  // for($i=0;$i<20;$i++){
  //   $this->pdf->Row(array("papa","Hellp","Ooo","oaoao"));
  // }
  $this->outPut();


}
}
