<?php namespace App\Controllers;

class Cars extends BaseController{
  public function __construct(){

  }

  public function index(){
    // $router = service('router');
    // echo $router->ControllerName();

    $data = [
      'titlePage' => 'Cars',
      'button' => 'Add To cart',
    ];
    echo view('cars/cars_all', $data);
  }

  public function detail($id){
    $data = [
      'titlePage' => 'Cars details',
    ];
    echo view('cars/cars_detail', $data);
  }


}
