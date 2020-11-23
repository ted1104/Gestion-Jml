<?php
namespace Modules\Admin\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord: Administration'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }

  public function config_depot(){
    $data = [
      'titlePage' => 'Configuration: Administration'
    ];
    echo view($this->linkMod.'\config\config-depot-view', $data);
  }
  public function config_critique(){
    $data = [
      'titlePage' => 'Configuration: Administration'
    ];
    echo view($this->linkMod.'\config\config-critique-view', $data);
  }


}
