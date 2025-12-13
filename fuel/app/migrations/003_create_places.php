<?php

namespace Fuel\Migrations;

class Create_places
{
	public function up()
	{
		\DBUtil::create_table('places', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment' => true, 'unsigned' => true),
			'name' => array('constraint' => 50, 'type' => 'varchar'),
			'place_id' => array('constraint' => 100, 'type' => 'varchar'),
			'genre_id' => array('constraint' => 11, 'type' => 'int'),
			'reservable' => array('constraint' => 11, 'type' => 'int'),
			'address' => array('type' => 'text'),
			'phone_number' => array('constraint' => 30, 'type' => 'varchar'),
			'closing_sun' => array('type' => 'bool'),
			'closing_mon' => array('type' => 'bool'),
			'closing_tue' => array('type' => 'bool'),
			'closing_wed' => array('type' => 'bool'),
			'closing_thu' => array('type' => 'bool'),
			'closing_fri' => array('type' => 'bool'),
			'closing_sat' => array('type' => 'bool'),
			'closing_hol' => array('type' => 'bool'),
			'closing_irregular' => array('type' => 'bool'),
			'website_url' => array('type' => 'text'),
			'note' => array('type' => 'text'),
			'user_id' => array('constraint' => 11, 'type' => 'int'),
			'created_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'updated_at' => array('constraint' => 11, 'type' => 'int', 'null' => true),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('places');
	}
}