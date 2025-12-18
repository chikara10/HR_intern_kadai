<?php

class Model_Place extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'name',
		'place_id',
		'genre_id',
		'reservable',
		'address',
		'phone_number',
		'closing_sun',
		'closing_mon',
		'closing_tue',
		'closing_wed',
		'closing_thu',
		'closing_fri',
		'closing_sat',
		'closing_hol',
		'closing_irregular',
		'website_url',
		'note',
		'user_id',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'places';

	protected static $_belongs_to = array(
        'genre' => array(
            'key_from' => 'genre_id',
            'model_to' => 'Model_Genre',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        )
    );

}
