<?php
namespace Modules\Admin\Controllers;

class Dashboard extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Tableau de Bord : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\dashboard-view', $data);
  }

  public function config_depot(){
    $data = [
      'titlePage' => 'Configuration : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\config\config-depot-view', $data);
  }
  public function config_critique(){
    $data = [
      'titlePage' => 'Configuration : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\config\config-critique-view', $data);
  }
  public function getCaissierMontant(){
    $data = [
      'titlePage' => 'Caissiers : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\users\caissiers-list-view', $data);
  }
  public function getEncaissementInterne(){
    $data = [
      'titlePage' => 'Decaissement Historique : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\caisse\encaissement-interne-historique-view', $data);
  }
  public function createUsers(){
    $data = [
      'titlePage' => 'Utilisateurs : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\users\users-add-view', $data);
  }
  public function getAllUsers(){
    $data = [
      'titlePage' => 'Utilisateurs : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\users\users-list-view', $data);
  }
  public function getEncaissementExterne(){
    $data = [
      'titlePage' => 'Encaissement Externe Historique : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\caisse\encaissement-externe-historique-view', $data);
  }
  public function getDecaissementInterne(){
    $data = [
      'titlePage' => 'Decaissement Historique : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\caisse\decaissement-externe-historique-view', $data);
  }

  public function getStockPv(){
    $data = [
      'titlePage' => 'STOCK PV : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
  }
  public function getRapport(){
    $data = [
      'titlePage' => 'RAPPORTS : ADMINISTRATION'
    ];
    // echo view($this->linkMod.'\rapport\rapport-view', $data);
    echo view('Modules\ModulePartage\Views\rapport\rapport-view', $data);
  }
  public function getConfigSystem(){
    $data = [
      'titlePage' => 'ACTION AVANCEE : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\config\config-avance-view', $data);
  }
  public function addClient(){
    $data = [
      'titlePage' => 'CLIENTS : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\client\clients-add-view', $data);
  }
  public function getListClient(){
    $data = [
      'titlePage' => 'CLIENTS : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\client\clients-list-view', $data);
  }


  public function getConfigZone(){
    $data = [
      'titlePage' => 'ZONES : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\config\config-zone-view', $data);
  }

  public function config_articles(){
    $data = [
      'titlePage' => 'ARTICLES : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\config\config-articles-view', $data);
  }

  public function getLogSystem(){
    $data = [
      'titlePage' => 'LOG SYSTEME : ADMINISTRATION'
    ];
    // echo view($this->linkMod.'\stock\depots-stock-pv-view', $data);
    echo view('Modules\ModulePartage\Views\logs-view', $data);
  }

  public function addDecaissement(){
    $data = [
      'titlePage' => 'DECAISSEMENT : ADMINISTRATION'
    ];
    // echo view($this->linkMod.'\decaissement-add-caissier-secondaire-view', $data);
    echo view('Modules\ModulePartage\Views\decaissement\decaissement-add-caissier-secondaire-view', $data);
  }









}
