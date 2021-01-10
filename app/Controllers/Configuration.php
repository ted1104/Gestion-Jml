<?php

namespace App\Controllers;

class Configuration extends BaseController {
  protected $title;
  public function __construct(){
    $this->title = 'Configuration : Mot de passe';
  }
  public function index(){
    $data = [
      'titlePage' => $this->title,
    ];
    echo view('config/Password-Profile-Config-view', $data);
  }
}
