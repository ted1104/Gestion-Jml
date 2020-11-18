<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;
use CodeIgniter\HTTP\Message;

class IsLoggedIn implements FilterInterface {
  protected $service;

  public function __construct(){
    $this->service = new Services();
  }
	public function before(RequestInterface $request, $arguments = null){
    if($this->service->session()->has('users')){
      $session  = $this->service->session()->get('users');
      if($session['isLoggedIn']){
        return true;
      }
      $this->service->session()->setFlashData('message',['title' => 'Session Expirée', 'content' => 'Votre session a été expirée! Veuillez vous reconnecter','color'=>'alert-info']);
      return redirect()->to(base_url('/'));
    }
  $this->service->session()->setFlashData('message',['title' => 'Session Expirée', 'content' => 'Votre session a été expirée! Veuillez vous reconnecter','color'=>'alert-info']);
    return redirect()->to(base_url('/'));

	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){

	}

}
