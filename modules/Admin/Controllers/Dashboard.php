<?php
namespace Modules\Admin\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Administration'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }
}
