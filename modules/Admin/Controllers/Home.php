<?php

namespace Modules\Admin\Controllers;

class Home extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Home::Admin'
    ];
    echo view($this->linkMod.'\home-view', $data);
  }

  // PROPERTIES FUNCTIONS GET

  public function property_get(){
    $data = [
      'titlePage' => 'Properties',
      'button' => 'Add To cart',

    ];
    echo view('properties/properties_all', $data);
  }
  public function property_get_one($id){
    $data = [
      'titlePage' => 'Properties details',
    ];
    echo view('properties/properties_detail', $data);
  }
  public function cars_get(){
      $data = [
        'titlePage' => 'Cars',
        'button' => 'Add To cart',
      ];
      echo view('cars/cars_all', $data);
  }
  public function cars_get_one($id){
    $data = ['titlePage' => 'Cars details'];
    echo view('cars/cars_detail', $data);
  }

  public function tenders_get(){
    $data = [
      'titlePage' => 'Tenders',

    ];
		echo view('tenders/tenders_all', $data);
  }
  public function tenders_get_one($id){
    $data = [
      'titlePage' => 'Tender details',
    ];
    echo view('tenders/tenders_detail', $data);
  }

  public function jobs_get(){
    $data = [
      'titlePage' => 'jobs',
    ];
    echo view('jobs/jobs_all', $data);

  }
  public function jobs_get_one($id){
    $data = [
        'titlePage' => 'Tender details',
      ];
      echo view('jobs/jobs_detail', $data);
  }
  public function auctions_get(){
    $data = [
      'titlePage' => 'Auction',
      'button' => 'Available',
    ];
    echo view('auctions/auctions_all', $data);
  }

  public function auctions_get_one(){
    $data = [
          'titlePage' => 'Auction details',
        ];
    echo view('auctions/auctions_detail', $data);
  }

}
