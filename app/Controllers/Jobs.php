<?php namespace App\Controllers;

class Jobs extends BaseController
{
	public function __construct(){

	}
	public function index()
	{
		$data = [
      'titlePage' => 'jobs',
    ];
		echo view('jobs/jobs_all', $data);
	}

	public function detail($id){
    $data = [
      'titlePage' => 'Tender details',
    ];
    echo view('jobs/jobs_detail', $data);
  }

	//--------------------------------------------------------------------

}
