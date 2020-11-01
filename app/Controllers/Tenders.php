<?php namespace App\Controllers;

class Tenders extends BaseController
{
	public function __construct(){

	}
	public function index()
	{
		$data = [
      'titlePage' => 'Tenders',
    
    ];
		echo view('tenders/tenders_all', $data);
	}

	public function detail($id){
    $data = [
      'titlePage' => 'Tender details',
    ];
    echo view('tenders/tenders_detail', $data);
  }

	//--------------------------------------------------------------------

}
