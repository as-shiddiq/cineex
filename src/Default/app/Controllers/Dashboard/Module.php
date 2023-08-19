<?php

namespace App\Controllers\Dashboard;

class Module extends BaseController
{
	public $url = 'module';
	private $title = 'Module';

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= 'Data '.$this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/'.'Module/'.ucwords(__FUNCTION__).'View',$data);
	}
	
}