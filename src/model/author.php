<?php
/**
 * Created by PhpStorm.
 * User: Rodas
 * Date: 9/24/2016
 * Time: 10:06 PM
 */

namespace Rodasnet\Blog\Model;

class Author extends Orm\Model_Soft
{
    protected static $_properties = array(
        'id',
        'username',
        'password',
        'group_id',
        'email',
        'last_login',
        'created_at',
        'updated_at',
        'deleted_at',
    );
    protected static $_table_name = 'users';

    protected static $_conditions = array(
        'order_by' => array('created_at' => 'desc'),
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

    protected static $_has_many = array(
        'posts' => [
            'key_from' => 'id',
            'model_to' => '\Rnblog\Model\Post',
            'key_to' => 'user_id',		// key in the related model
            'cascade_save' => true,		// update the related table on save
            'cascade_delete' => false,
        ],
        'users_metadata' => array(
            'key_from' => 'id',			// key in this model
            'model_to' => '\Rnblog\Model\Author\Metadata',      // related model
            'key_to' => 'parent_id',		// key in the related model
            'cascade_save' => true,		// update the related table on save
            'cascade_delete' => true,		// delete the related data when deleting the parent
        ),
    );

//     define the EAV container like so
    protected static $_eav = array(
        'users_metadata' => array(			// we use the statistics relation to store the EAV data
            'model_to' => '\Rnblog\Model\Author\Model_Users_Metadata',      // related model
            'attribute' => 'key',		// the key column in the related table contains the attribute
            'value' => 'value',			// the value column in the related table contains the value
        )
    );

}