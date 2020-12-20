<?php
namespace Modules\Magazin\Controllers;

class Achat extends BaseController {


  public function index(){
    $data = [
      'titlePage' => 'ACHAT: Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-view', $data);
  }
  public function addAppro(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT: Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-add-view', $data);
  }
  public function getHistoriqueAppro(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT: Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-historique-magaz-view', $data);
  }
  public function getStockDepot(){
    $data = [
      'titlePage' => 'MON STOCK: Dépôt'
    ];
    echo view($this->linkMod.'\depots-stock-magaz-view', $data);
  }


}
