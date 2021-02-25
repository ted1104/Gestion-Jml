<?php
namespace Modules\Facturier\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Facturation'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
  public function getConfigSystem(){
    $data = [
      'titlePage' => 'ACTION AVANCEE: Facturier'
    ];
    echo view('Modules\Admin\Views\config\config-avance-view', $data);
  }

  public function getStockPv(){
    $data = [
      'titlePage' => 'Dépot PV : Facturier'
    ];
    echo view('Modules\Admin\Views\stock\depots-stock-pv-view', $data);
  }
}
