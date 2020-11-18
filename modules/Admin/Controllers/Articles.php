<?php
namespace Modules\Admin\Controllers;

class Articles extends BaseController {
  public function index(){
    $data = [
      'titlePage' => 'Article: Administration'
    ];
    echo view($this->linkMod.'\articles\articles-add-view', $data);
  }
}
