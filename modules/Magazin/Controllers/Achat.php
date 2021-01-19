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
    echo view($this->linkMod.'\stock\depots-stock-magaz-view', $data);
  }

  public function getAchatFaveur(){
    $data = [
      'titlePage' => 'ACHAT FAVEURS: Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-faveur-view', $data);
  }

  public function addApproInterDepot(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT: Inter-Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-inter-depot-add-view', $data);
  }
  public function getHistoriqueApproInterDepot(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT: Inter-Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-inter-depot-historique-view', $data);
  }
  public function getStockPv(){
    $data = [
      'titlePage' => 'MON STOCK: Dépôt'
    ];
    echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
  }


}
