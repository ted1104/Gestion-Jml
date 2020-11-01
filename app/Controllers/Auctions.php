<?php namespace App\Controllers;

class Auctions extends BaseController{
  public function __construct(){

  }

  public function index(){
    // $router = service('router');
    // echo $router->ControllerName();

    $data = [
      'titlePage' => 'Auction',
      'button' => 'Available',
    ];

    echo view('auctions/auctions_all', $data);
  }

  public function detail(){
    $data = [
      'titlePage' => 'Auction details',
    ];
    echo view('auctions/auctions_detail', $data);
  }


}
