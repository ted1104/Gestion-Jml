<?php

namespace Modules\Admin\Controllers;
use App\Entities\UsersEntity;


class Login extends BaseController {
  protected $title;
  public function __construct(){
    $this->title = 'Login';
  }
  public function index(){
    $data = [
      'titlePage' => $this->title,
    ];
    echo view($this->linkMod.'\login-view', $data);
  }

  public function login(){
    $data = $this->request->getPost();
    $auth = $this->usersModel->authLogin($data);
    if($auth){
      $this->session->set('users', $auth);
      return redirect()->to('admin-home.dy');
    }else{
      $data = [
        'titlePage' => $this->title,
      ];
      $this->session->setFlashData('message',['title' => 'Login Error', 'content' => 'Identifiants ou Mot de passe incorrects!!','color'=>'popup__danger']);
      // print_r($this->session->getFlashData('message')['content']);
      // exit();
      return redirect()->to('login.dy')->withInput();
      // echo view($this->linkMod.'\login-view', $data);
    }

  }

  public function logout(){
    // $this->session->destroy();
    $this->session->remove('users');
    $this->session->setFlashData('message',['title' => 'Logout Info', 'content' => 'You are logged Out !!','color'=>'popup__info']);
    // print_r($this->session->getFlashData('message'));
    // exit();
    return redirect()->to('login.dy');
  }


}
