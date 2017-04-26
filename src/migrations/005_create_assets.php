<?php

namespace Fuel\Migrations;

class Create_assets
{
	public function up()
	{
		\DBUtil::create_table('rn_assets', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('type' => 'text', 'null' => true),
			'content' => array('type' => 'text', 'null' => true),
			'type' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'uri' => array('constraint' => 255, 'type' => 'varchar', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('rn_assets');
	}
}