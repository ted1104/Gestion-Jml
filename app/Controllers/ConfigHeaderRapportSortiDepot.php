<?php
namespace App\Controllers;
use App\Models\ArticlesModel;

class ConfigHeaderRapportSortiDepot extends TableFpdf
{

  //public function __construct(){
    //$this->articlesModel = new ArticlesModel();
  //}
  function Header(){
    if( $this->PageNo() !== 1 ){
      $articlesModel = new ArticlesModel();
      $allArticle = $articlesModel->Where('is_show_on_rapport',1)->findAll();
      $enteTableArticle = array();
      $DonneTableArticle = array();
      for($i = 0; $i < count($allArticle); $i++){
        array_push($enteTableArticle,273/count($allArticle));
        array_push($DonneTableArticle,utf8_decode($allArticle[$i]->nom_article));
      }
      $this->SetWidths($enteTableArticle);
      $this->SetFont('Helvetica','B',6);
      $this->Cell(14,5,'Produit',1,0,'L');
      $this->Row($DonneTableArticle);
    }
  }
  function Footer(){
      $this->SetY(-15);
      $this->SetFont('Arial','B',8);
      $this->Cell(0,10,'Page : '.$this->PageNo().' sur {nb}',0,0,'C');
  }
}
?>
