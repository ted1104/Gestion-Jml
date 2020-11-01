<?php namespace App\Controllers;

class Properties extends BaseController{
  public function __construct(){

  }

  public function index(){
    // $router = service('router');
    // echo $router->ControllerName();

    $data = [
      'titlePage' => 'Properties',
      'button' => 'Add To cart',

    ];

    echo view('properties/properties_all', $data);
  }

  public function detail($id){
    $data = [
      'titlePage' => 'Properties details',
    ];
    echo view('properties/properties_detail', $data);
  }

  public function cart(){
    $data = [
      'titlePage' => 'Cart',
      'items_list' => [
        '1' => ['prix'=>'500 000','img'=>'ByOseMarketVehicule01','tile'=>'Toyota Rav4'],
        '2' => ['prix'=>'600 000','img'=>'ByOseMarketProperties','tile'=>'Fully Furnished House'],
        '3' => ['prix'=>'700 000','img'=>'ByOseMarketVehicule02','tile'=>'Toyota Rav4'],
        '4' => ['prix'=>'800 000','img'=>'ByOseMarketProperties','tile'=>'Fully Furnished House']
      ]
    ];
    echo view('cart', $data);
  }

}
