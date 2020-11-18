<?php
namespace Modules\Caisse\Controllers;

class Achat extends BaseController {

  public function index(){
    $data = [
      'titlePage' => 'ACHAT: Caissier'
    ];
    echo view($this->linkMod.'\achat-list-caisse-view', $data);
  }
  public function achatCaissier(){
    $data = [
      'titlePage' => 'ACHAT: Caissier'
    ];
    echo view('Modules\Facturier\Views\achat-add-view', $data);
  }
  public function decaissementSend(){
    $data = [
      'titlePage' => 'DECAISSEMENT: Caissier'
    ];
    echo view($this->linkMod.'\decaissement-add-view', $data);
  }

  //LISTE DE DECAISSEMENT DEMANDES PAR LES CAISSIERS SECONDAIRES ET POSSIBILITE DE FAIRE LE DECAISSEMENT CAISSIER PRINCIPAL
  public function decaissementListCaissierMain(){
    $data = [
      'titlePage' => 'DECAISSEMENT: Caissier'
    ];
    echo view($this->linkMod.'\decaissement-list-caissier-main-view', $data);
  }
}
