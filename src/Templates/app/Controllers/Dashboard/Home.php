<?php

namespace App\Controllers\Dashboard;

class Home extends BaseController
{
    public $url = 'home';
    private $title = 'Dashboard';

    public function index()
    {
        $data['id']= $id??'';
        $data['btnToolbar']= ['back'];
        $data['title']= $this->title;
        $data['page']= 'Form '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        return view('Dashboard/'.'Home/'.ucwords(__FUNCTION__).'View',$data);
    }
}
