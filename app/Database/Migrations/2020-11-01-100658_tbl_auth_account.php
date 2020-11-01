<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblAuthAccount extends Migration
{
	public function up()
	{
		//
		$this->forge->addField([
			'id'=>[
				'type' => 'INT',
				'constraint'=> 9,
				'auto_increment' =>true
			],
			'username'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>false
			],
			'password_main'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>false
			],
			'password_op'=>[
				'type'=> 'DATE',
				'null'=>true
			],
			'user_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'status_users_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'created_at'=>[
				'type'=>'TIMESTAMP',
				'null'=> false
			],
			'updated_at'=>[
				'type'=>'TIMESTAMP',
				'null'=> false
			],
			'deleted_at'=>[
				'type'=>'TIMESTAMP',
				'null'=> false
			]

			]);
			$this->forge->addKey('id', true);
			$this->forge->addForeignKey('user_id','g_users','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('status_users_id','st_status_account','id','CASCADE','CASCADE');
			$this->forge->createTable('g_users_auth');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
