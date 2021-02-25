<?php

namespace App\Controllers;

class Configuration extends BaseController {
  protected $title;
  protected $link;
  public function __construct(){
    $this->title = 'Configuration : Mot de passe';
    $this->link = 'http://jml.local';
    //$this->link  = 'http://127.0.0.1/GestionBoutique/api/v1/users-debloque-account';
  }
  public function index(){
    $data = [
      'titlePage' => $this->title,
    ];
    echo view('config/Password-Profile-Config-view', $data);
  }

  public function user_desable_account(){
    $client = \Config\Services::curlrequest();
    $response = $client->request('GET', $this->link, [
         'headers' => ['authorization' => '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627']
    ]);
    echo $response->getStatusCode();
  }
  public function user_enable_account(){
    $client = \Config\Services::curlrequest();

    $response = $client->request('GET', $this->link, [
         'headers' => ['authorization' => '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627']
    ]);
    echo $response->getStatusCode();
  }
  public function clotureStock(){
    $client = \Config\Services::curlrequest();
    $response = $client->request('GET', $this->link, [
         'headers' => ['authorization' => '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627']
    ]);
    echo $response->getStatusCode();
  }
  public function clotureCaisse(){
    $client = \Config\Services::curlrequest();
    $response = $client->request('GET', $this->link, [
         'headers' => ['authorization' => '3bacb9ec-9fbc-4442-ab76-3a6e35b0a627']
    ]);
    echo $response->getStatusCode();
  }
}
