<?php

namespace Rodasnet\Blog\Model;

class Image extends Media
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
}
