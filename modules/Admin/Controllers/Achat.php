<?php
namespace Modules\Admin\Controllers;

class Achat extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Achat : Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-view', $data);
  }
  public function negotiation_list(){
    $data = [
      'titlePage' => 'Negotiation : Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-negotiation-view', $data);
  }
  public function getAchatPartiel(){
    $data = [
      'titlePage' => 'Achat Partiel : Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-partiel-view', $data);
  }
  public function achatAddAdmin(){
    $data = [
      'titlePage' => 'VENTES : ADMINISTRTION'
    ];
    echo view('Modules\Facturier\Views\achat-add-view', $data);
  }
  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : ADMINISTRTION'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : ADMINISTRTION'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }


  public function getAchatAretirer(){
    $data = [
      'titlePage' => 'ACHATS A RETIRER : ADMINISTRTION'
    ];
    echo view($this->linkMod.'\achat\achat-list-a-retirer-view', $data);
  }

}
