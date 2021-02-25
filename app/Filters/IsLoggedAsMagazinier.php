<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;
use CodeIgniter\HTTP\Message;

class IsLoggedAsMagazinier implements FilterInterface {
  protected $service;

  public function __construct(){
    $this->service = new Services();
  }
	public function before(RequestInterface $request, $arguments = null){


	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){
      if($this->service->session()->has('users')){
        $session  = $this->service->session()->get('users');
        if($session['info'][0]->roles_id !=5){
          $this->service->session()->setFlashData('message',['title' => 'Attention! Action Non permise', 'content' => 'Vous avez tenté d\'acceder frauduleusement à une fonctionnalité non permise! Cette action malveillante sera notifié à l\'administrateur pour plus d\'éclaircissement','color'=>'alert-danger']);
          return redirect()->to(base_url('/'));
        }
        return;
        $this->service->session()->setFlashData('message',['title' => 'Session Expirée', 'content' => 'Votre session a été expirée! Veuillez vous reconnecter','color'=>'alert-info']);
        return redirect()->to(base_url('/'));
      }
        $this->service->session()->setFlashData('message',['title' => 'Session Expirée', 'content' => 'Votre session a été expirée! Veuillez vous reconnecter','color'=>'alert-info']);
        return redirect()->to(base_url('/'));

	}

}
