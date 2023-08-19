<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configemail extends Migration
{
    public $table = 'config_email';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'config_email_nama'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_host'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_smptsecure'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_smtpauth'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 10,
                'null'           => true,
            ],
            'config_email_username'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_password'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_port'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true,
            ],
            'config_email_template'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'default'=>'default',
                'null'           => true,
            ],
            'config_email_footnote'   => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'config_email_footer'   => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'showtable' => true
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type'          => 'VARCHAR',
                'null'          => true,
                'constraint'    => '36',
            ],
            'updated_by' => [
                'type'          => 'VARCHAR',
                'null'          => true,
                'constraint'    => '36',
            ],
            'deleted_by' => [
                'type'          => 'VARCHAR',
                'null'          => true,
                'constraint'    => '36',
            ],
        ];
    public function up()
    {
        $this->forge->addField($this->fields);
         $this->forge->addKey('id', true);
        $this->forge->createTable($this->table);
    }

    public function down()
    {
        $this->forge->dropTable($this->table);
    }
}
