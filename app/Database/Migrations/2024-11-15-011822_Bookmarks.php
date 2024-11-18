<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Bookmarks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'user_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'pengaduan_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);

        // Foreign key for pengaduan_id
        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('bookmarks');
    }

    public function down()
    {
        $this->forge->dropForeignKey('bookmarks', 'pengaduan_id');

        $this->forge->dropTable('bookmarks');
    }
}
