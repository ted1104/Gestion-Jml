<?php
namespace Modules\Admin\Controllers;

class Achat extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Achat : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\achat\achat-list-view', $data);
  }
  public function negotiation_list(){
    $data = [
      'titlePage' => 'Negotiation : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\achat\achat-list-negotiation-view', $data);
  }
  public function getAchatPartiel(){
    $data = [
      'titlePage' => 'Achat Partiel : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\achat\achat-list-partiel-view', $data);
  }
  public function achatAddAdmin(){
    $data = [
      'titlePage' => 'VENTES : ADMINISTRATION'
    ];
    echo view('Modules\Facturier\Views\achat-add-view', $data);
  }
  public function achatListAdmin(){
    $data = [
      'titlePage' => 'VENTES : ADMINISTRATION'
    ];
    echo view('Modules\Caisse\Views\achat-list-caisse-view', $data);
  }
  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : ADMINISTRATION'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : ADMINISTRATION'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }


  public function getAchatAretirer(){
    $data = [
      'titlePage' => 'ACHATS A RETIRER : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\achat\achat-list-a-retirer-view', $data);
  }

}
