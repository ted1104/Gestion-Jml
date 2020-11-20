<?php

namespace App\Controllers;
use FPDF;
use App\Models\CommandesModel;


class PdfGenerate extends BaseController {
  protected $pdf;
  protected $commande;
  public function __construct(){
    $this->pdf = new FPDF();

    $this->commande = new CommandesModel();

  }
  public function index($code){
    $data = $this->commande->find($code);
    $this->pdf = new FPDF("L","pt", array(140,200));
    $this->pdf->SetFont('Helvetica','B',10);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();
    $this->pdf->Cell(190,10,'Date : '.$data->created_at,0,1,'C');
    $this->pdf->Ln();
    $this->pdf->Cell(190,10,'Client : '.$data->nom_client,0,1,'C');
    $this->pdf->SetFont('Helvetica','B',20);
    $this->pdf->Cell(190,40,$data->numero_commande,0,1,'C');

    $this->outPut();

  }

  public function facture($code){
    $data = $this->commande->find($code);
    // print_r($data->logic_article);
    // exit();
    $this->pdf = new FPDF("L","pt", array(300,300));
    $this->pdf->SetFont('Helvetica','B',9);
    $this->pdf->SetMargins(5,5,5);
    $this->pdf->AddPage();

    // $this->pdf->SetXY(5,5);

    $this->pdf->Cell(170,15,utf8_decode('FACTURE N° : '.$data->numero_commande),0,0,'L');
    $this->pdf->Cell(120,15,'Date : '.$data->created_at,0,1,'L');
    $this->pdf->Cell(290,15,'Nom du Client : '.$data->nom_client,0,1,'L');

    $this->pdf->Cell(290,15,'DETAIL ACHAT ',0,1,'C');
    $this->pdf->Ln();
    $header = ['Article', 'Qte', 'PU','PT'];
    $this->BasicTableHeader($header,290);
    $this->pdf->SetFont('Helvetica','',8);
    $montantTotalAchat = 0;
    foreach ($data->logic_article as $key => $value) {

      // $montant = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ?$value->qte_vendue * $value->prix_unitaire:$value->qte_vendue * $value->prix_negociation;

      $prixUnitaire = ($value->is_negotiate == 0 || $value->is_negotiate == 1) ? $value->prix_unitaire:$value->prix_negociation;

      $montantTotalParArticle = round($prixUnitaire * $value->qte_vendue,2);

      $this->pdf->Cell(155,15,utf8_decode($value->articles_id[0]->nom_article),1,0);
      $this->pdf->Cell(45,15,$value->qte_vendue,1,0);

      $this->pdf->Cell(45,15,utf8_decode($prixUnitaire.' USD'),1,0);
      $this->pdf->Cell(45,15,utf8_decode($montantTotalParArticle.' USD'),1,1);

      $montantTotalAchat += $montantTotalParArticle;
    }
    $this->pdf->SetFont('Helvetica','B',10);
    $this->pdf->Cell(245,30,'TOTAL ',0,0,'R');
    $this->pdf->Cell(45,30,$montantTotalAchat.' USD',0,1,'L');
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
          $wColN = $col==='Article'?$wCol+($wCol/2)*3-(8.75*3):$wCol/2+8.75;
          $this->pdf->Cell($wColN,15,$col,1);
      endforeach;
      $this->pdf->Ln();
  }


}