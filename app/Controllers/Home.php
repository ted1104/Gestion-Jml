<?php namespace App\Controllers;

class Home extends BaseController
{
	public function __construct(){

	}
	public function index()
	{

		$data = ['titlePage' => 'Home'];
		echo view('home_page', $data);
	}

	//--------------------------------------------------------------------

}
