<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblInterneVenteAffectation extends Migration
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
			'vente_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'users_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'date_affectation'=>[
				'type'=> 'DATE',
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
			$this->forge->addForeignKey('vente_id','g_interne_vente','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('users_id','g_users','id','CASCADE','CASCADE');
			$this->forge->createTable('g_interne_vente_affectation');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
