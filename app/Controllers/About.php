<?php namespace App\Controllers;

class About extends BaseController{
  public function __construct(){

  }

  public function index(){
    $data = [
      'titlePage' => 'Who We Are',
    ];
    echo view('divers/WhoWeAre', $data);
  }

  public function whatWeDo(){
    $data = [
      'titlePage' => 'What we do',
    ];
    echo view('divers/WhatWeDo', $data);
  }


}
