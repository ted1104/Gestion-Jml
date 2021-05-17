<?php
namespace Modules\Caisse\Controllers;

class Achat extends BaseController {

  public function index(){
    $data = [
      'titlePage' => 'ACHAT : Caissier'
    ];
    echo view($this->linkMod.'\achat-list-caisse-view', $data);
  }
  public function achatCaissier(){
    $data = [
      'titlePage' => 'ACHAT : Caissier'
    ];
    echo view('Modules\Facturier\Views\achat-add-view', $data);
  }
  public function decaissementSend(){
    $data = [
      'titlePage' => 'DECAISSEMENT : Caissier'
    ];
    echo view($this->linkMod.'\decaissement-add-caissier-secondaire-view', $data);
  }

  //LISTE DE DECAISSEMENT DEMANDES PAR LES CAISSIERS SECONDAIRES ET POSSIBILITE DE FAIRE LE DECAISSEMENT CAISSIER PRINCIPAL
  public function decaissementListCaissierMain(){
    $data = [
      'titlePage' => 'DECAISSEMENT : Caissier'
    ];
    echo view($this->linkMod.'\decaissement-list-caissier-main-view', $data);
  }
  public function listCaissier(){
    $data = [
      'titlePage' => 'ACHAT : Caissier'
    ];
    echo view('Modules\Admin\Views\users\caissiers-list-view', $data);
  }

  public function getEncaissementExterne(){
    $data = [
      'titlePage' => 'ENCAISSEMENT EXTERNE : Caissier'
    ];
    echo view($this->linkMod.'\encaissement-caissier-main-view', $data);
  }
  public function addPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Caissier'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-add-view', $data);
  }
  public function getPvPerdue(){
    $data = [
      'titlePage' => 'PV PERDUE : Caissier'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\pv-historique-list-view', $data);
  }

}
