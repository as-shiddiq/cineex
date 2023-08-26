<?php
use \Firebase\JWT\JWT;
function privateKey()
{
    $privateKey = <<<EOT
    -----BEGIN RSA PRIVATE KEY-----
    MIICXAIBAAKBgQC8kGa1pSjbSYZVebtTRBLxBz5H4i2p/llLCrEeQhta5kaQu/Rn
    vuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t0tyazyZ8JXw+KgXTxldMPEL9
    5+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4ehde/zUxo6UvS7UrBQIDAQAB
    AoGAb/MXV46XxCFRxNuB8LyAtmLDgi/xRnTAlMHjSACddwkyKem8//8eZtw9fzxz
    bWZ/1/doQOuHBGYZU8aDzzj59FZ78dyzNFoF91hbvZKkg+6wGyd/LrGVEB+Xre0J
    Nil0GReM2AHDNZUYRv+HYJPIOrB0CRczLQsgFJ8K6aAD6F0CQQDzbpjYdx10qgK1
    cP59UHiHjPZYC0loEsk7s+hUmT3QHerAQJMZWC11Qrn2N+ybwwNblDKv+s5qgMQ5
    5tNoQ9IfAkEAxkyffU6ythpg/H0Ixe1I2rd0GbF05biIzO/i77Det3n4YsJVlDck
    ZkcvY3SK2iRIL4c9yY6hlIhs+K9wXTtGWwJBAO9Dskl48mO7woPR9uD22jDpNSwe
    k90OMepTjzSvlhjbfuPN1IdhqvSJTDychRwn1kIJ7LQZgQ8fVz9OCFZ/6qMCQGOb
    qaGwHmUK6xzpUbbacnYrIM6nLSkXgOAwv7XXCojvY614ILTK3iXiLBOxPu5Eu13k
    eUz9sHyD6vkgZzjtxXECQAkp4Xerf5TGfQXGXhxIX52yH+N2LtujCdkQZjXAsGdm
    B2zNzvrlgRmgBrklMTrMYgm1NPcW+bRLGcwgW2PTvNM=
    -----END RSA PRIVATE KEY-----
    EOT;
    return $privateKey;
}

function publicKey()
{
    $publicKey = <<<EOT
    -----BEGIN PUBLIC KEY-----
    MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
    4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
    0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
    ehde/zUxo6UvS7UrBQIDAQAB
    -----END PUBLIC KEY-----
    EOT;
    return $publicKey;
}

function auth($ar=array())
{
    helper('app');
    helper('tanggal');
    $request = \Config\Services::request();
    $PenggunaModel = new \App\Models\PenggunaModel();

    //get token information
    $authorization = $request->getServer('HTTP_AUTHORIZATION');
    if($authorization!=null)
    {
        $getToken = explode(' ', $authorization);
        if(count($getToken)>1){
            $token = $getToken[1];
        }
    }
    else if($request->getGet('token'))
    {
        $token = $request->getGet('token');
    }
    else
    {
        $token = session()->get('token');
    }
    //end get token information

    //validating the token
    if($token!=null && $token!='')
    {

        $decodeToken  = decodeToken($token);
        if($decodeToken==false)
        {
            return false;
        }
        // validate the userID
        if($decodeToken->userId=='' ||  $decodeToken->userId==null)
        {
            return false;
        }
    }
    //end validating the token
    if(isset($decodeToken))
    {
        $userId = $decodeToken->userId;
        $getPengguna = $PenggunaModel->select('pengguna.pengguna_username,
                                        pengguna.pengguna_foto,
                                        pengguna.id,
                                        pengguna.pengguna_status,
                                        pengguna.pengguna_nama,
                                        pengguna.pengguna_hp,
                                        pengguna.pengguna_email,
                                        pengguna.signed_at,
                                        pengguna.created_at,
                                        pengguna.updated_at')
                                    ->select('pengguna_level_nama')
                                    ->join('pengguna_level','pengguna.pengguna_level_id=pengguna_level.id')
                                    ->where('pengguna.id',$userId)
                                    ->where('pengguna.pengguna_status','A')
                                    ->first();

        if($getPengguna!=null)
        {
            $getPengguna->pengguna_foto_url = uploads('pengguna',$getPengguna->pengguna_foto,'user.jpg');

            if($getPengguna->pengguna_level_nama!='Administrator')
            {
                $modules = $getPengguna->pengguna_level_nama;
                $getModel = '\\Modules\\'.$modules.'\\Models\\'.$modules.'penggunaModel';
                if(class_exists($getModel))
                {
                    $model = new $getModel;
                    $getSubData = $model->withAddons()
                                        ->asArray()
                                        ->where('pengguna_id',$getPengguna->id)
                                        ->first();
                    $getPengguna->has = [];
                    if($getSubData!=null)
                    {
                        $unsetAr = ['created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'];
                        foreach ($getSubData as $key => $value) {
                            if(!in_array($key,$unsetAr))
                            {
                                $getPengguna->has[$key] = $value;
                            }
                        }
                    }
                    else
                    {
                        return false;
                    }

                }
            }
            return $getPengguna;
        }
        else {
            return false;
        }
    }
    else
    {
        return false;
    }
}


function setToken($config)
{
    $request = \Config\Services::request();
    $configWeb = configWeb();
    $issuer_claim = site_url();
    $audience_claim = $configWeb->config_web_nama;
    $issuedat_claim = time(); 
    $notbefore_claim = $issuedat_claim;
    if($request->getPost('remember')){
        $expire_claim = $issuedat_claim + 72000; // expire time in seconds
    }
    else{
        $expire_claim = $issuedat_claim + 36000; // expire time in seconds
    }

    if($request->getPost('from')=='mobile'){
        $expire_claim = $issuedat_claim + 360000; // expire time in seconds
    }

    // if(isset($config['longsession']))
    // {
    //     $expire_claim = $issuedat_claim + $config['longsession']; // expire time in seconds
    // }

    $payload = [
        "iss" => $issuer_claim,
        "aud" => $audience_claim,
        "iat" => $issuedat_claim,
        "nbf" => $notbefore_claim,
        "exp" =>$expire_claim,
        "data" => [
            "userId" => $config['id'],
            "userLevel" => $config['level'],
            "others" => $config
        ]
    ];

    JWT::$leeway = 5;
    //token
    $token = JWT::encode($payload, privateKey(), 'RS256');
    session()->set('token',$token);
    return $token;
}

function decodeToken($token)
{
    $publicKey = publicKey();
    try 
    {
        $decoded = JWT::decode($token, $publicKey, ['RS256']);
        // $check=aksesLevel($url,$activity,$decoded->data->pengguna_level);
        return $decoded->data;
    } 
    catch (\Exception $e)
    {
        return false;
    }

}