<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAveriasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'cliente'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'problema'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'fechahora'  => ['type' => 'DATETIME', 'null' => false],
            'status'     => ['type' => 'ENUM', 'constraint' => ['PENDIENTE','EN_PROCESO','CUMPLIDA'], 'default' => 'PENDIENTE'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('averias', true);
    }

    public function down()
    {
        $this->forge->dropTable('averias', true);
    }
}
