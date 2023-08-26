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

function Auth($ar=array())
{
    helper('app');
    helper('tanggal');
    $PenggunaModel = new \App\Models\PenggunaModel();
    if(session()->get('userId'))
    {
        $userId = session()->get('userId');
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
    return false;
}
