<?php

namespace App\Controllers\Dashboard;

class Configweb extends BaseController
{
	public $url = 'configweb';
	private $title = 'Web Configuration';

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/'.'Configweb/'.ucwords(__FUNCTION__).'View',$data);
	}
	
}