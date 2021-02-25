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
}
