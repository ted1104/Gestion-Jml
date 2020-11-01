<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TblUsers extends Migration
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
			'nom'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>false
			],
			'prenom'=>[
				'type'=> 'VARCHAR',
				'constraint'=>250,
				'null'=>false
			],
			'sexe'=>[
				'type'=> 'VARCHAR',
				'constraint'=>1,
				'null'=>false
			],
			'dob'=>[
				'type'=> 'DATE',
				'null'=>true
			],
			'role_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'depot_id'=>[
				'type'=> 'INT',
				'constraint'=>9,
				'null'=>false
			],
			'date_debut_service'=>[
				'type'=> 'DATE',
				'null'=>true
			],
			'date_fin_service'=>[
				'type'=> 'DATE',
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
			$this->forge->addForeignKey('role_id','st_roles','id','CASCADE','CASCADE');
			$this->forge->addForeignKey('depot_id','st_depots','id','CASCADE','CASCADE');
			// $this->forge->createTable('g_users');


	}

	//--------------------------------------------------------------------

	public function down()
	{
		//
	}
}
