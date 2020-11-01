<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use Config\Services;
use CodeIgniter\HTTP\Message;

class AuthApiKey implements FilterInterface {
  protected $service;

  public function __construct(){
    $this->service = new Services();
    $this->message = new Message();
  }
	public function before(RequestInterface $request, $arguments = null){
    $req = $request->getHeaderLine('Authorization');
    if($req === env('apikey')){
      return true;
    }
    $data = [
      'status' => 401,
      'message' => 'Invalid API Key',
      // 'data' => $request->getHeaders()
    ];
    return $this->service->response()->setStatusCode(401)
                                     ->setJSON($data);
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){

	}

}
