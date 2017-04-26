<?php

namespace Fuel\Migrations;

class Create_authors
{
	public function up()
	{
		\DBUtil::create_table('rn_authors', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'username' => array('constraint' => 50, 'type' => 'varchar'),

			'group_id' => array('constraint' => 11, 'type' => 'int'),
			'email' => array('constraint' => 255, 'type' => 'varchar'),
			'last_login' => array('constraint' => 25, 'type' => 'varchar'),
			'previous_login' => array('constraint' => 25, 'type' => 'varchar'),

			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
            'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
        // Create admin user
//       \Auth::instance()->create_user('admin','admin','admin@blog.com','100');
//       \Auth::instance()->create_user('daniel.rodas1@yahoo.com','Daniel','daniel.rodas1@yahoo.com','100');
//       \Auth::instance()->create_user('zigbs.zigbs@gmail.com','Tyler','zigbs.zigbs@gmail.com','100');
//       \Auth::instance()->create_user('stefanofg@gmail.com','Stefano','stefanofg@gmail.com','100');
	}

	public function down()
	{
		\DBUtil::drop_table('rn_authors');
	}
}