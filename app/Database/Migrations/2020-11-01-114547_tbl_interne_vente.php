<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblInterneVente extends Migration
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
			'date_vente'=>[
				'type'=> 'DATE',
				'null'=>false
			],
			'status_vente_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'users_id'=>[
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
			$this->forge->addForeignKey('status_vente_id','st_status_vente','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('users_id','g_users','id','CASCADE','CASCADE');
			// $this->forge->createTable('g_interne_vente');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
