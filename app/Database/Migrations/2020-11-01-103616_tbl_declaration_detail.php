<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDeclarationDetail extends Migration
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
			'declaration_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'articles_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_declaree'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'montant_paye'=>[
				'type'=> 'DECIMAL',
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
			$this->forge->addForeignKey('declaration_id','g_externe_declaration','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('articles_id','g_articles','id','CASCADE','CASCADE');
			$this->forge->createTable('g_externe_detail_declaration');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
