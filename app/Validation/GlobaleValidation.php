<?php namespace App\Validation;

use CondeIgniter\HTTP\RequestInterface;
use Config\Services;

class GlobaleValidation {
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

	public function checkingForeignKeyExist(string $fields, string $data){
		$db = \Config\Database::connect();
		$value = $fields;
		$table = explode(',',$data)[0];
		$nameKey = explode(',',$data)[1];

    $query = $db->table($table)->getWhere([$nameKey => $value]);
    $data = $query->getRow();
    if($data){
      return true;
    }
    return false;
	}
}
