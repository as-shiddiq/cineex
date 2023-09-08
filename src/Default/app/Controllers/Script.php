<?php

namespace App\Controllers;

class Script extends BaseController
{
    public $url = 'auth';
    private $title = 'Beranda';

    public function auth()
    {
        $auth = auth();
        if($auth!==false)
        {
            $data = $auth;
        }
        else
        {
            $data = false;
        }
        echo 'let auth = '.json_encode($auth);
        $this->response->setHeader('Content-Type','application/javascript');
    }
}
