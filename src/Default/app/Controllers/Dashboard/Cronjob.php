<?php

namespace App\Controllers\Dashboard;

class Cronjob extends BaseController
{
	
	public $url = 'cronjob';
	private $title = 'Cronjob';
	public function __construct(){
	}

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
        $data['btnToolbar']= ['back'];
		$data['now']= __FUNCTION__;
        return view('Dashboard/Cronjob/'.ucwords(__FUNCTION__).'View',$data);
	}

}