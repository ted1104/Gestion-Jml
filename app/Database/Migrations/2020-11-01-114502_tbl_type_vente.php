<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblTypeVente extends Migration
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
			'description'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'unique' => true,
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
			$this->forge->createTable('st_status_vente');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
