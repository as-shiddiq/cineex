<?php

namespace App\Controllers;

class Home extends BaseController
{
    public $url = 'home';
    private $title = 'Beranda';

    public function index()
    {
        $data['id']= $id??'';
        $data['btnToolbar']= ['back'];
        $data['title']= $this->title;
        $data['page']= 'Form '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = 'main';
        $data['fullPage'] = true;
        return view('Main/'.'Home/'.ucwords(__FUNCTION__).'View',$data);
    }
}
