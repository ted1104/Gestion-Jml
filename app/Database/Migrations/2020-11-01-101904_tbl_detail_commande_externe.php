<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDetailCommandeExterne extends Migration
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
			'date_commande'=>[
				'type'=> 'DATE',
				'null'=>false
			],
			'commandes_externe_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'articles_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_commande'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'Prix_achat_unitaire_estime'=>[
				'type'=> 'DECIMAL',
				'null'=>false
			],
			'Prix_achat_reel'=>[
				'type'=> 'DECIMAL',
				'null'=>false,
				'default' => null
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
			$this->forge->addForeignKey('commandes_externe_id','g_externe_commandes','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('articles_id','g_articles','id','CASCADE','CASCADE');
			$this->forge->createTable('g_externe_detail_commandes');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
