<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Cronjob extends Migration
{
    public $table = 'cronjob';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'cronjob_module'   => [
                'type'           => 'VARCHAR',
                'constraint'     => 150,
                'null'           => true,
            ],
            'cronjob_log'   => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'start_at'   => [
                'type' => 'DATETIME',
                'null' => true,
                'null' => true,
            ],
            'finish_at'   => [
                'type' => 'DATETIME',
                'null' => true,
                'null' => true,
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
