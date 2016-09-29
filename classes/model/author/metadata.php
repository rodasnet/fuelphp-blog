<?php

namespace Rnblog\Model\Author;

class Metadata extends \Orm\Model
{
    // list of properties for this model
    protected static $_properties = array(
        'id', // primary key
        'parent_id', // foreign key
        'key', // attribute column
        'value', // value column
    );
    protected static $_table_name = 'users_metadata';
    // set up the patient relation the usual way
    protected static $_belongs_to = array(
        'author' => array(
            'key_from' => 'parent_id',
            'model_to' => '\Rnblog\Model\Author',
            'key_to' => 'id',
            'cascade_save' => true,
            'cascade_delete' => true,
        )
    );
}
