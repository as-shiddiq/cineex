<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Join extends Migration
{
    public $table = 'join';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            'join_from_id'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 36,
            ],
            'join_to_id'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 36,
            ],
            'join_from'   => [
                    'type'           => 'VARCHAR',
                    'constraint'     => 100,
                    'null'           => true,
            ],
            'join_to'   => [
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
