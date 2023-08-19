<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pengguna extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'pengguna_level_id'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint'    => 36,
            ],
            'pengguna_foto'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 100,
            ],
            'pengguna_nama'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 100,
            ],
            'pengguna_username'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 50,
            ],
            'pengguna_password'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 100,
            ],
            'pengguna_email'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 100,
            ],
            'pengguna_hp'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => 20,
            ],
            'pengguna_status'       => [
                'type'       => 'ENUM',
                'null' => true,
                'default' => 'A',
                'constraint' => ['A', 'N','B'],
            ],
            'signed_at'       => [
                'null' => true,
                'type' => 'DATETIME',
            ],
            'token'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => '100',
            ],
            'otp'       => [
                'type'       => 'VARCHAR',
                'null' => true,
                'constraint' => '10',
            ],
            'expired_at'       => [
                'null' => true,
                'type' => 'DATETIME',
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
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}
