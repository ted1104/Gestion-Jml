<?php namespace App\Validation;

use CondeIgniter\HTTP\RequestInterface;
use Config\Services;

class DateValidation {
	private $request;

	public function __construct(RequestInterface $request = null){
		if(is_null($request))
		{
			$request = Services::request();
		}
		$this->request = $request;
	}

	public function compareDate(string $fields, string $data)
	{
    $nameChamps = explode(',', $data);
    $dateQuiDoitEtreInferieur = strtotime($this->request->getPost($nameChamps[0]));
    $dateQuiDoitEtreSuperieur = strtotime($this->request->getPost($nameChamps[1]));

    if($dateQuiDoitEtreInferieur < $dateQuiDoitEtreSuperieur){
      return true;
    }
    return false;

	}
}
