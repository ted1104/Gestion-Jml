<?php
namespace Modules\Gerant\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Gérant'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }

  public function getAchatList(){
    $data = [
      'titlePage' => 'Achat : Gérant'
    ];
    echo view('Modules\Admin\Views\achat\achat-list-view', $data);
  }
  public function getStock(){
    $data = [
      'titlePage' => 'Dépôts : Gérant'
    ];
    echo view('Modules\Admin\Views\stock\depots-stock-view', $data);
  }
  public function getHistoriqueAppro(){
    $data = [
      'titlePage' => 'Approvisionnement : Gérant'
    ];
    echo view('Modules\Admin\Views\appro\appro-historique-view', $data);
  }
  public function getHistoriqueApproInterDepot(){
    $data = [
      'titlePage' => 'Approvisionnement Inter-Dépôt : Gérant'
    ];
    echo view('Modules\Admin\Views\appro\appro-inter-depot-historique-view', $data);
  }
  public function getConfigSystem(){
    $data = [
      'titlePage' => 'Action Avancée : Gérant'
    ];
    echo view('Modules\Admin\Views\config\config-avance-view', $data);
  }
  public function getStockPv(){
    $data = [
      'titlePage' => 'Dépot PV : Gérant'
    ];
    echo view('Modules\Admin\Views\stock\depots-stock-pv-view', $data);
  }
  public function getAchatListPartiel(){
    $data = [
      'titlePage' => 'Achat Partiel PV : Gérant'
    ];
    echo view('Modules\Admin\Views\achat\achat-list-partiel-view', $data);
  }
  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Gérant'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Gérant'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }




}
