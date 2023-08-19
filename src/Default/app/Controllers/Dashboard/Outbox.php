<?php

namespace App\Controllers\Dashboard;

class Outbox extends BaseController
{
	
	public $url = 'outbox';
	private $title = 'Outbox';
	public function __construct(){
	}

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
        $data['btnToolbar']= ['back'];
		$data['now']= __FUNCTION__;
        return view('Dashboard/Outbox/'.ucwords(__FUNCTION__).'View',$data);
	}

	public function preview($type='email')
	{	
		$data['title']= $this->title;
		$data['page']= $this->title;
		$data['url']= $this->url;
        $data['btnToolbar']= ['back'];
		$data['now']= __FUNCTION__;
		$data['configWeb'] = configWeb();
		$data['configEmail'] = configEmail();
		$data['type']= $type;
        return view('Dashboard/Outbox/'.ucwords(__FUNCTION__).'View',$data);
	}



}