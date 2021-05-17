<?php
namespace Modules\Magazin\Controllers;

class Achat extends BaseController {


  public function index(){
    $data = [
      'titlePage' => 'ACHAT : Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-view', $data);
  }
  public function addAppro(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT : Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-add-view', $data);
  }
  public function getHistoriqueAppro(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT : Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-historique-magaz-view', $data);
  }
  public function getStockDepot(){
    $data = [
      'titlePage' => 'MON STOCK : Dépôt'
    ];
    echo view($this->linkMod.'\stock\depots-stock-magaz-view', $data);
  }

  public function getAchatFaveur(){
    $data = [
      'titlePage' => 'ACHAT FAVEURS : Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-faveur-view', $data);
  }

  public function addApproInterDepot(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT : Inter-Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-inter-depot-add-view', $data);
  }
  public function getHistoriqueApproInterDepot(){
    $data = [
      'titlePage' => 'APPROVISONNEMENT : Inter-Dépôt'
    ];
    echo view($this->linkMod.'\appro\appro-inter-depot-historique-view', $data);
  }
  public function getStockPv(){
    $data = [
      'titlePage' => 'MON STOCK PV : Dépôt'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\Admin\Views\stock\depots-stock-pv-view', $data);
  }

  public function getAchatPartiel(){
    $data = [
      'titlePage' => 'ACHAT PARTIEL : Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-partiel-view', $data);
  }
  public function addTransfertDepot(){
    $data = [
      'titlePage' => 'TRANSFERT : Dépôt'
    ];
    echo view($this->linkMod.'\transfert\transfert-depot-add-view', $data);
  }
  public function getTransfertDepot(){
    $data = [
      'titlePage' => 'TRANSFERT : Dépôt'
    ];
    echo view($this->linkMod.'\transfert\transfert-depot-historique-view', $data);
  }
  public function getStockPersonnelMagaz(){
    $data = [
      'titlePage' => 'MON STOCK PERSONNEL : Dépôt'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view($this->linkMod.'\stock\depots-stock-personnel-magaz-view', $data);
  }
  public function getAchatAretireMagaz(){
    $data = [
      'titlePage' => 'MES ACHATS A RETIRER : Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-a-retirer-view', $data);
  }

  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Dépôt'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Dépôt'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }



}
