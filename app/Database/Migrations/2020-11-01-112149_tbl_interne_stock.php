<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblInterneStock extends Migration
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
			'articles_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'depot_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_stock'=>[
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
			$this->forge->addForeignKey('articles_id','g_articles','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('depot_id','st_depots','id','CASCADE','CASCADE');
			$this->forge->createTable('g_interne_stock');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
