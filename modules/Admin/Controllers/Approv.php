<?php
namespace Modules\Admin\Controllers;

class Approv extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Approvisionnement : Administration'
    ];
    echo view($this->linkMod.'\appro\appro-add-view', $data);
  }
  public function historique(){
    $data = [
      'titlePage' => 'Approvisionnement : Administration'
    ];
    echo view($this->linkMod.'\appro\appro-historique-view', $data);
  }
  public function stockDepots(){
    $data = [
      'titlePage' => 'Dépôt : Administration'
    ];
    echo view($this->linkMod.'\stock\depots-stock-view', $data);
  }

  public function historiqueInterDepot(){
    $data = [
      'titlePage' => 'Approvisionnement Inter-Dépôt : Administration'
    ];
    echo view($this->linkMod.'\appro\appro-inter-depot-historique-view', $data);
  }
  public function getHistoTransfert()
  {
    $data = [
      'titlePage' => 'HISTORIQUE TRANSFERTS : Administration'
    ];
    echo view($this->linkMod.'\transfert\transfert-historique-view', $data);
  }
  public function getStockPersonnel()
  {
    $data = [
      'titlePage' => 'STOCK PERSONNEL MAGASINIER : Administration'
    ];
    echo view($this->linkMod.'\stock\stock-personnel-view', $data);
  }




}
