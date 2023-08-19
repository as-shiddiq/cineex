<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ModuleSeeder extends Seeder
{
    public function run()
    {
        helper('app');
        $ModuleModel = new \App\Models\ModuleModel();
        $ModuleModel->skipValidation(true);
        $ar = [
            'Pengguna'=>'Pengguna',
            'Penggunalevel'=>'Pengguna Level',
            'Module'=>'Module',
            'Configweb'=>'Configweb',
            'Configemail'=>'Configemail',
        ];
        foreach ($ar as $k=>$v) {
            $check = $ModuleModel->where('module_nama',$k)->first();
            if($check == null)
            {
                $ModuleModel->insert([
                    'id'=>uuid(),
                    'module_nama'=>$k,
                    'module_deskripsi'=>$v,
                    'module_status'=>'D',
                ]);
            }
        }
    }
}
