<?php
namespace Modules\Facturier\Controllers;

class Achat extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'ACHAT : Facturation'
    ];
    echo view($this->linkMod.'\achat-add-view', $data);
  }

  public function get_all(){
    $data = [
      'titlePage' => 'ACHAT : Facturation'
    ];
    echo view($this->linkMod.'\achat-list-view', $data);
  }
  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Facturation'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Facturation'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }

}
