<?php

namespace Rodasnet\Blog\Model;

class Media extends \Orm\Model_Soft
{
    protected static $_properties = array(
        'id',
        'name',
        'content'=> array(
            'null' => true
        ),
		'type' => array(
             'null' => true
        ),
		'uri'=> array(
             'null' => true
        ),
		'deleted_at',
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

	protected static $_soft_delete = array(
		'mysql_timestamp' => false,
	);

	protected static $_table_name = 'assets';


    /**
     * Asset HasMany Galleries
     * @var array
     */
    protected static $_has_many = array(
        'galleries' => array(
            'key_from' => 'id',
            'model_to' => '\Rodasnet\Blog\Model\Gallery',
            'key_to' => 'asset_id',
            'cascade_save' => false,
            'cascade_delete' => false,  // We do NOT delete all assests from the gallery deleted
        ),
    );
}
