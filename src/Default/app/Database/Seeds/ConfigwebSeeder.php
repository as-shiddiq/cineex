<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigwebSeeder extends Seeder
{
    public function run()
    {
        helper('app');
        $Model = new \App\Models\ConfigwebModel();
        $ar = [   
            [   
                'id' => uuid(),
                'config_web_nama' => 'Cineex',
                'config_web_deskripsi'=>'CodeIgniter Next and Extendable',
                'config_web_hp'=>'083159236892',
                'config_web_alamat'=>'Sarang Halang',
                'config_web_email'=>'nasrullahsiddik@gmail.com',
                'config_web_meta_description'=>'Cineex is CodeIigniter Next and Extendable',
                'config_web_meta_keyword'=>'CodeIgniter, CMS, Website, Cineex',
                'config_web_script_top'=>'',
                'config_web_script_bottom'=>'',
                'config_web_icon_light'=>'icon.png',
                'config_web_icon_dark'=>'icon.png',
                'config_web_logo_light'=>'logo.png',
                'config_web_logo_dark'=>'logo-dark.png',
            ]
        ];
       foreach ($ar as $k=>$v) {
            $check = $Model->first();
            if($check == null)
            {
                $Model->insert($v);
            }
        }
    }
}
