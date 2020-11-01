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
      $this->service->session()->setFlashData('message',['title' => 'Session Expired!', 'content' => 'Your session is expired! Please logged in','color'=>'popup__info']);
      return redirect()->to(base_url('login.dy'));
    }
    $this->service->session()->setFlashData('message',['title' => 'Session Expired!', 'content' => 'Your session is expired! Please logged in','color'=>'popup__info']);
    return redirect()->to(base_url('login.dy'));

	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){

	}

}
