<?php

namespace App\Controllers;



class Login extends BaseController {
  protected $title;
  public function __construct(){
    $this->title = 'Login';
  }
  public function index(){
    $data = [
      'titlePage' => $this->title,
    ];
    echo view('login-view', $data);
  }

  public function login(){
    $data = $this->request->getPost();
    $auth = $this->userAuthModel->authLogin($data);
    if($auth){
      if($auth !=2){
        $this->session->setFlashData('message',['title' => 'Bienvenue !!', 'content' => 'Amusez vous bien '.$auth['info'][0]->nom.' '.$auth['info'][0]->prenom.'. Nous vous souhaitons un excelent travail','color'=>'alert-success']);
        $redirectLink = checkroleandredirect($auth['info'][0]->roles_id);
        $this->session->set('users', $auth);
        $this->session->set('profile', $redirectLink->description);
        return redirect()->to($redirectLink->routes);
      }else{
        $data = [
          'titlePage' => $this->title,
        ];
        $this->session->setFlashData('message',['title' => 'Compte bloqué', 'content' => 'Ce compte est bloqué temporairement; veuillez contacter l\'administrateur principal du système!!','color'=>'alert-info']);
        return redirect()->to('/')->withInput();
      }
      }else{
        $data = [
          'titlePage' => $this->title,
        ];
        $this->session->setFlashData('message',['title' => 'Connexion Erreur', 'content' => 'Identifiants ou Mot de passe incorrects!!','color'=>'alert-danger']);
        return redirect()->to('/')->withInput();

      }
  }

  public function logout(){
    $this->session->remove('users');
    $this->session->setFlashData('message',['title' => 'Deconnexion Info', 'content' => 'Vous vous êtes deconnecté! Bye A plus tard','color'=>'alert-info']);
    return redirect()->to(base_url());
  }

}
