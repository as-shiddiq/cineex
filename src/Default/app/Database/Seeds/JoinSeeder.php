<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JoinSeeder extends Seeder
{
    public function run()
    {
        //
        helper('app');
        // $Model = new \App\Models\JoinModel();
        // $Model->skipValidation(true);
        // $fromId = 'c60c297c-708f-45ab-87f6-340aae504147';
        // $from = 'gis_kategori';
        // $to = 'poin_sektor';
        // $toId = [
        //     '3469e920-0d94-4300-94fe-4ad8e796f922',
        //     '67d24a44-f4e8-4456-af0c-dc1b8019c83b',
        //     '75edb6bc-546f-4f18-8afa-2e1b10b4263e',
        //     'a574a552-613f-4140-a735-bea65a667f85',
        //     'cb5f4d78-de44-402f-8607-80f48c1af4fa'
        // ];
        // foreach ($toId as $k=>$v) {
        //     $check = $Model->where('join_to',$to)
        //                     ->where('join_to_id',$v)
        //                     ->where('join_from_id',$fromId)
        //                     ->where('join_from',$from)
        //                     ->first();
        //     if($check == null)
        //     {
        //         $Model->insert([
        //             'id'=>uuid(),
        //             'join_to_id'=>$v,
        //             'join_from_id'=>$fromId,
        //             'join_to'=>$to,
        //             'join_from'=>$from

        //         ]);
        //     }
        // }
    }
}
