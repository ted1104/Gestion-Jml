<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblHistoriquePrix extends Migration
{
	public function up()
	{
		//
		//
		$this->forge->addField([
			'id'=>[
				'type' => 'INT',
				'constraint'=> 9,
				'auto_increment' =>true
			],
			'commandes_externe_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'prix_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'type_prix'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'prix_unitaire'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_decideur'=>[
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
			$this->forge->addForeignKey('prix_id','g_prix','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('commandes_externe_id','g_externe_commandes','id','CASCADE','CASCADE');
			$this->forge->createTable('g_prix_historique');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
