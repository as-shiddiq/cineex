<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfigemailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => uuid(),
            'config_email_nama' => 'Cineex',
            'config_email_host'=>'mail.kodingakan.com',
            'config_email_smptsecure'=>'tls',
            'config_email_smtpauth'=>'TRUE',
            'config_email_username'=>'noreply@kodingakan.com',
            'config_email_password'=>'------',
            'config_email_port'=>'587',
            'config_email_footnote'=>'<p>Cineex (CodeIgniter Next and Extendable)</p>',
            'config_email_footer'=>'<p>Powered by <a href="https://kodingakan.com">Cineex.</a></p>',


        ];

        // Insert data
        $this->db->table('configemail')->insert($data);
    }
}
