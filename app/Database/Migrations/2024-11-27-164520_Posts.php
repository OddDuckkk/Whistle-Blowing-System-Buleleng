<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Posts extends Migration
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
            'parent_id' => [
                'type'       => 'CHAR',
                'constraint' => 36,
                'null'       => true, 
            ],
            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'is_deleted' => [
                'type' => 'BOOLEAN',
                'null' => false,
                'default' => false,
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

        $this->forge->addForeignKey('pengaduan_id', 'pengaduan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('parent_id', 'posts', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('posts');
    }

    public function down()
    {
        $this->forge->dropForeignKey('posts', 'posts_pengaduan_id_foreign');
        $this->forge->dropForeignKey('posts', 'posts_parent_id_foreign');

        $this->forge->dropTable('posts');
    }
}
