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
  public function getCaissierMontant(){
    $data = [
      'titlePage' => 'Caissiers: Administration'
    ];
    echo view($this->linkMod.'\users\caissiers-list-view', $data);
  }
  public function getDecaissement(){
    $data = [
      'titlePage' => 'Decaissement Historique: Administration'
    ];
    echo view($this->linkMod.'\caisse\decaissement-historique-view', $data);
  }
  public function createUsers(){
    $data = [
      'titlePage' => 'Utilisateurs: Administration'
    ];
    echo view($this->linkMod.'\users\users-add-view', $data);
  }
  public function getAllUsers(){
    $data = [
      'titlePage' => 'Utilisateurs: Administration'
    ];
    echo view($this->linkMod.'\users\users-list-view', $data);
  }








}
