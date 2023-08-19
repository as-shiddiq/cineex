<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PenggunaSeeder extends Seeder
{
    public function run()
    {
        helper('app');
        $PenggunalevelModel = new \App\Models\PenggunalevelModel();
        $PenggunaModel = new \App\Models\PenggunaModel();
        $PenggunalevelModel->skipValidation(true);
        $PenggunaModel->skipValidation(true);

        $penggunaLevelId = uuid();

        $arLevel = [
            $penggunaLevelId=>'Administrator',
            uuid()=>'Pegawai'
        ];

        foreach ($arLevel as $k => $v) {
            $rPenggunaLevel = $PenggunalevelModel->where('pengguna_level_nama',$v)->first();
            if($rPenggunaLevel==null)
            {  
                $PenggunalevelModel->insert([
                    'id'=>$k,
                    'pengguna_level_nama'=>$v
                ]);
            }
        }


        $check = $PenggunaModel->where('pengguna_username','admin')->first();
        if($check==null)
        {
            $PenggunaModel->insert(
                [
                    'id' => uuid(),
                    'pengguna_level_id' => $penggunaLevelId,
                    'pengguna_nama' => 'Administrator',
                    'pengguna_username' => 'admin',
                    'pengguna_password' => password_hash('admin',PASSWORD_DEFAULT),
                    'pengguna_email' => 'admin@admin.com',
                    'pengguna_hp' => '-',
                    'pengguna_status' => 'A',
                ]
            );
        }
    }
}
