<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblDeclaration extends Migration
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
			'commandes_externe_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'date_declaration'=>[
				'type'=> 'DATE',
				'null'=>false
			],
			'users_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'commentaire'=>[
				'type'=> 'TEXT',
				'null'=>true
			],
			'montant_paye'=>[
				'type'=> 'INT',
				'constraint'=>9,
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
			// $this->forge->addForeignKey('commandes_externe_id','g_externe_commandes','id','CASCADE','CASCADE');
			// $this->forge->addForeignKey('users_id','g_users','id','CASCADE','CASCADE');
			// $this->forge->createTable('g_externe_transport');
	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
