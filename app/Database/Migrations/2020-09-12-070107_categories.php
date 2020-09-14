<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Categories extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 9,
				'auto_increment' => true,
			],
			'name' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
			],
			'status' => [
				'type'       => 'ENUM',
				'constraint' => ['Approved', 'Pending', 'Draft'],
				'default'    => 'Approved',
	        ],
			'created_at'  => [
				'type'       => 'DATETIME'
			],
			'modified_at'  => [
				'type'       => 'DATETIME'
			],
			'timestamp'  => [
				'type'       => 'TIMESTAMP',
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->addKey('timestamp');
		$this->forge->createTable('categories', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('categories', true);
	}
}
