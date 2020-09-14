<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type'           => 'INT',
				'constraint'     => 9,
				'auto_increment' => true,
			],
			'username' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
			],
			'email' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
			],
			'password' => [
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => false
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
		$this->forge->createTable('users', true);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('users', true);
	}
}
