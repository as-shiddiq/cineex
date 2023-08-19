<?php

namespace App\Controllers;

class Layanan extends BaseController
{
    public $url = 'tiket';
    private $title = 'Tiket';

    public function cetak($permohonanKode='')
    {
        helper(['npdf','ntanggal']);
        if($permohonanKode!='')
        {
            $data['id']= $id??'';
            $data['btnToolbar']= ['back'];
            $data['title']= $this->title;
            $data['page']= 'Form '.$this->title;
            $data['url']= $this->url;
            $data['now']= __FUNCTION__;
            $data['permohonanKode'] = $permohonanKode;
            $html = view('App\\Modules\\Layanan\\Views\\Cetak\\'.ucfirst($this->url).'View',$data);
            if($this->request->getGet('debug'))
            {
                echo $html;
            }
            else
            {
                generatePdf($html,'tiket'.$permohonanKode,'a5','portrait','download');
            }
        }
    }
}
