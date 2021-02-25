<?php
namespace Modules\Facturier\Controllers;

class Achat extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'ACHAT : Facturation'
    ];
    echo view($this->linkMod.'\achat-add-view', $data);
  }

  public function get_all(){
    $data = [
      'titlePage' => 'ACHAT : Facturation'
    ];
    echo view($this->linkMod.'\achat-list-view', $data);
  }

}
