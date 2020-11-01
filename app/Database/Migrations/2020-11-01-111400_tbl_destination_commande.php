<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDestinationCommande extends Migration
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
			'transport_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'depot_id'=>[
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
			$this->forge->addForeignKey('transport_id','g_externe_transport','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('depot_id','st_depots','id','CASCADE','CASCADE');
			$this->forge->createTable('g_destination_commande_externe');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
