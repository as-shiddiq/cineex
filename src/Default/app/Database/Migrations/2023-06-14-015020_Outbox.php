<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Outbox extends Migration
{
     public $table = 'outbox';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'outbox_pengirim'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
                'null'           => true,
            ],
            'outbox_tujuan'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
                'null'           => true,
            ],
            'outbox_nama'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
                'null'           => true,
            ],
            'outbox_pesan'   => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'outbox_meta'   => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'outbox_tipe'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 50, #EMAIL< WA < OTHER
                'null'           => true,
            ],
            'sent_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'showtable' => true
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
