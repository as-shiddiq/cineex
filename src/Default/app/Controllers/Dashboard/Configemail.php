<?php

namespace App\Controllers\Dashboard;

class Configemail extends BaseController
{
	public $url = 'configemail';
	private $title = 'Email Configuration';

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/Configemail/'.ucwords(__FUNCTION__).'View',$data);
	}
	
}