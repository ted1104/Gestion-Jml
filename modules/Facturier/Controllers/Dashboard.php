<?php
namespace Modules\Facturier\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Facturation'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
}
