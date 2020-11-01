<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblPannesExterne extends Migration
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
			'reception_detail_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'panne_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_en_panne'=>[
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
			$this->forge->addForeignKey('reception_detail_id','g_externe_detail_reception','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('panne_id','st_pannes','id','CASCADE','CASCADE');
			$this->forge->createTable('st_externe_pannes_eventuelles');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
