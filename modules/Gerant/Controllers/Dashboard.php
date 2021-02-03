<?php
namespace Modules\Gerant\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Caissier'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
}
