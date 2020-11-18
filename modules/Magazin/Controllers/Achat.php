<?php
namespace Modules\Magazin\Controllers;

class Achat extends BaseController {


  public function index(){
    $data = [
      'titlePage' => 'ACHAT: Dépôt'
    ];
    echo view($this->linkMod.'\achat-list-magaz-view', $data);
  }
}
