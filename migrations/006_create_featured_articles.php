<?php

namespace Fuel\Migrations;

class Create_featured_articles
{
	public function up()
	{
		\DBUtil::create_table('rn_featured_articles', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'article_id' => array('constraint' => 11, 'type' => 'int'),
			'asset_id' => array('constraint' => 11, 'type' => 'int'),
			'featured_on' => array('type' => 'datetime'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'deleted_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('rn_featured_articles');
	}
}