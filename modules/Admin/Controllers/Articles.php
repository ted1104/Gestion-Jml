<?php
namespace Modules\Admin\Controllers;

class Articles extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Article : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\articles\articles-add-view', $data);
  }
  public function list(){
    $data = [
      'titlePage' => 'Article : ADMINISTRATION'
    ];
    echo view($this->linkMod.'\articles\articles-list-view', $data);
  }
}
