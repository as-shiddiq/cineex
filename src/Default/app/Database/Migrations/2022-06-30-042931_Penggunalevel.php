<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penggunalevel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'pengguna_level_nama'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint'    => 36,
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
        $this->forge->createTable('pengguna_level');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna_level');
    }
}
