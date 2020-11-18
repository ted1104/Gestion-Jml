<?php
namespace Modules\Magazin\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Dépot'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
}
