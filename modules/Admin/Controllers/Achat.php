<?php
namespace Modules\Admin\Controllers;

class Achat extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Achat: Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-view', $data);
  }
  public function negotiation_list(){
    $data = [
      'titlePage' => 'Negotiation: Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-negotiation-view', $data);
  }
  public function getAchatPartiel(){
    $data = [
      'titlePage' => 'Achat Partiel: Administration'
    ];
    echo view($this->linkMod.'\achat\achat-list-partiel-view', $data);
  }

}
