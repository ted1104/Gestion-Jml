<?php

namespace App\Controllers;
use App\Models\LogSystemModel;


class Login extends BaseController {
  protected $title;
  protected $logSystemModel = null;

  public function __construct(){
    $this->title = 'Login';
    $this->logSystemModel = new LogSystemModel();

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
        $this->session->set('accessDroit',getAllDroitAccess($auth['info'][0]->id));
        $this->session->set('profile', $redirectLink->description);
        $this->session->set('lieuAffectation', getLieuAffectationDetail($auth['info'][0]->depot_id));
        $this->logSystemModel->addLogSys($auth['info'][0]->id, 2);
        return redirect()->to($redirectLink->routes);
      }else{
        $data = [
          'titlePage' => $this->title,
        ];
        $this->logSystemModel->addLogSys($auth['info'][0]->id, 6);
        $this->session->setFlashData('message',['title' => 'Compte bloqué', 'content' => 'Ce compte est bloqué ou temporairement non opérationnel; veuillez contacter l\'administrateur principal du système!!','color'=>'alert-info']);
        return redirect()->to(base_url())->withInput();
      }
      }else{
        $data = [
          'titlePage' => $this->title,
        ];
        $this->logSystemModel->addLogSys(null, 5, $this->request->getPost("username"));
        $this->session->setFlashData('message',['title' => 'Connexion Erreur', 'content' => 'Identifiants ou Mot de passe incorrects!!','color'=>'alert-danger']);
        return redirect()->to(base_url())->withInput();

      }
  }

  public function logout(){
    $this->logSystemModel->addLogSys(session('users')['info'][0]->id, 3);
    $this->session->remove('users');
    $this->session->setFlashData('message',['title' => 'Deconnexion Info', 'content' => 'Vous vous êtes deconnecté! Bye A plus tard','color'=>'alert-info']);
    return redirect()->to(base_url());
  }

}
