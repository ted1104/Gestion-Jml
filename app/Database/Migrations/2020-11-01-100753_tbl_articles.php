<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblArticles extends Migration
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
			'code_article'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'unique' => true,
				'null'=>false
			],
			'nom_article'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>false
			],
			'poids'=>[
				'type'=> 'DECIMAL',
				'null'=>true
			],
			'description'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>true
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
			$this->forge->createTable('g_articles');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
