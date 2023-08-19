<?php

namespace App\Controllers\Dashboard;

class Penggunalevel extends BaseController
{
	public $url = 'penggunalevel';
	private $title = 'Level Pengguna';

	public function index()
	{	
		$data['title']= $this->title;
		$data['page']= 'Data '.$this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/'.'Penggunalevel/'.ucwords(__FUNCTION__).'View',$data);
	}

	public function form($id='')
	{	
		$data['id']= $id;
		$data['title']= $this->title;
		$data['page']= 'Form '.$this->title;
		$data['url']= $this->url;
		$data['now']= __FUNCTION__;
        return view('Dashboard/'.'Penggunalevel/'.ucwords(__FUNCTION__).'View',$data);
	}

	
}