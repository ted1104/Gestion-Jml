<?php
namespace Modules\Admin\Controllers;

class Approv extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Approvisionnement: Administration'
    ];
    echo view($this->linkMod.'\appro\appro-add-view', $data);
  }
  public function historique(){
    $data = [
      'titlePage' => 'Approvisionnement: Administration'
    ];
    echo view($this->linkMod.'\appro\appro-historique-view', $data);
  }



}