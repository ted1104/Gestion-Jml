<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblInterneVenteDetailHistorique extends Migration
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
			'vente_detail_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_vendue'=>[
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
			$this->forge->addForeignKey('vente_detail_id','g_interne_vente_detail','id','CASCADE','CASCADE');
			$this->forge->createTable('g_interne_vente_detail_historique');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
