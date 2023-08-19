<?php


function Auth($ar=array())
{
    helper('app');
    helper('ntanggal');
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

function checkApiKey($apikey)
{
    $MemberModel = new \App\Models\MemberModel();
    $checkMember = $MemberModel->where('member_apikey',$apikey)
                        ->where('expired_at >=',timestamp())
                        ->first();
    if($checkMember==null)
    {
        return false;
    }
    else
    {
        return true;
    }
}