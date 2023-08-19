<@php

namespace {namespace};

use CodeIgniter\Database\Migration;

class {class} extends Migration
{
<?php if ($session): ?>
    protected $DBGroup = '<?= $DBGroup ?>';

    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'VARCHAR', 'constraint' => 128, 'null' => false],
<?php if ($DBDriver === 'MySQLi'): ?>
            'ip_address' => ['type' => 'VARCHAR', 'constraint' => 45, 'null' => false],
            'timestamp timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL',
            'data' => ['type' => 'BLOB', 'null' => false],
 <?php elseif ($DBDriver === 'Postgre'): ?>
            'ip_address inet NOT NULL',
            'timestamp timestamptz DEFAULT CURRENT_TIMESTAMP NOT NULL',
            "data bytea DEFAULT '' NOT NULL",
<?php endif; ?>
        ]);
<?php if ($matchIP) : ?>
        $this->forge->addKey(['id', 'ip_address'], true);
<?php else: ?>
        $this->forge->addKey('id', true);
<?php endif ?>
        $this->forge->addKey('timestamp');
        $this->forge->createTable('<?= $table ?>', true);
    }

    public function down()
    {
        $this->forge->dropTable('<?= $table ?>', true);
    }
<?php else: ?>
    public $table = '<?=$table?>';
    public $fields = [
            'id'          => [
                'type'           => 'VARCHAR',
                'constraint'    => 36,
            ],
            # activate if with join
            #'other_id' => [
            #    'type' => 'VARCHAR',
            #    'constraint'    => 36,
            #    'join' => 'other',
            #    'jointable' => ["other_nama"], # show in model and table or IndexView 
            #    'joinform' => ["id","other_nama"] #show in form or FormView as select
            #],
            'nama' => [
                'type' => 'VARCHAR',
                'null' => true,
                'constraint'    => 20,
                'showtable' => true, # show in table or IndexView || default is false 
                'showform' => true, #show in form or FormView || default is false
                # 'nestedparent' => true, # if parent will be default nested || default is false
                # 'nestedsort' => 'field', # this value required if nestedparent true
            ],
            //
            //add your field here
            //
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
<?php endif ?>
}
