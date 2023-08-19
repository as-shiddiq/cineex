<?php

namespace App\Controllers;

class Gis extends BaseController
{
    public $url = 'gis';
    private $title = 'GIS';

    public function overview()
    {
        $data['id']= $id??'';
        $data['btnToolbar']= ['back'];
        $data['title']= $this->title;
        $data['page']= 'Form '.$this->title;
        $data['url']= $this->url;
        $data['now']= __FUNCTION__;
        $data['render'] = 'main';
        return view('Main/Gis/'.ucwords(__FUNCTION__).'View',$data);
    }
}
