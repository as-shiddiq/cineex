<?php

namespace App\Controllers\Dashboard;

class Join extends BaseController
{
    public $url = 'join';
    private $title = 'Join Data';

    public function index()
    {
        $data['id']= $id??'';
        $data['btnToolbar']= ['back'];
        $data['title']= $this->title;
        $data['page']= 'Form '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        return view('Dashboard/Join/'.ucwords(__FUNCTION__).'View',$data);
    }
}
