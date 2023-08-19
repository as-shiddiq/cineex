<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModuleModel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'module_nama'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 100,
            ],
            'module_deskripsi'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 250,
            ],
            'module_urutan'       => [
                'type'       => 'INT',
                'default' => 0,
                'constraint' => 11,
            ],
            'module_status'       => [
                'type'       => 'ENUM',
                'null' => true,
                'default' => 'D', #default additional
                'constraint' => ['D', 'A'],
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
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
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('module');
    }

    public function down()
    {
        $this->forge->dropTable('module');
    }
}
