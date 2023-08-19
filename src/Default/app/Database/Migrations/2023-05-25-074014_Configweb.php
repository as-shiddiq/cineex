<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Configweb extends Migration
{
    public $table = 'config_web';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'config_web_nama'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_deskripsi'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_hp'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_alamat'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_email'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_meta_description'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_meta_keyword'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_script_top'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_script_bottom'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_script_setting'   => [
                    'type'           => 'TEXT',
                    'null'           => true,
            ],
            'config_web_icon_light'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_icon_dark'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_logo_light'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'config_web_logo_dark'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
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