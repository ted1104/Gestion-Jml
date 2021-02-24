<?php
namespace Modules\Magazin\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Dépot'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
  public function getConfigSystem(){
    $data = [
      'titlePage' => 'ACTION AVANCEE: Dépôt'
    ];
    echo view('Modules\Admin\Views\config\config-avance-view', $data);
  }
}
