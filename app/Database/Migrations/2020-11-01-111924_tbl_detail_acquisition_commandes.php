<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDetailAcquisitionCommandes extends Migration
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
			'acquisition_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'articles_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_acquis'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_en_panne'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'qte_bonne'=>[
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
			$this->forge->addForeignKey('acquisition_id','g_acquision_commande_externe','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('articles_id','g_articles','id','CASCADE','CASCADE');
			// $this->forge->createTable('g_externe_detail_transport');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
