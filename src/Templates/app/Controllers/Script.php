<?php

namespace App\Controllers;

class Script extends BaseController
{
    public $url = 'auth';
    private $title = 'Beranda';

    public function auth()
    {
        $auth = Auth();
        if($auth!==false)
        {
            $data = $auth;
        }
        else
        {
            $data = false;
        }
        echo 'let auth = '.json_encode($auth);
    }
}
