<?php

namespace Rodasnet\Blog\Model;

class Post extends Orm\Model_Soft
{
    public static function _init()
    {
        \Module::load('media');
    }
    protected static $_properties = array(
        'id',
        'name' => array(
            'label' => 'post.model.name',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'slug' => array(
            'label' => 'post.model.slug',
            'null' => false,
        ),
        'content' => array(
            'label' => 'post.model.content',
            'null' => false,
            'validation' => array('required'),
            'form' => array('type' => 'textarea'),
        ),
        'original_url' => array(
            'label' => 'post.model.original_url',
            'null' => false,
//            'validation' => array('required'),
            'form' => array('type' => 'text'),
        ),
        'category_id' => array(
            'label' => 'post.model.category_id',
            'form' => array('type' => 'select'),
            'null' => false,
            'validation' => array('required', 'is_numeric'),
        ),
        'user_id' => array(
            'label' => 'post.model.user_id',
            'form' => array('type' => 'select'),
            'null' => false,
            'validation' => array('is_numeric'),
        ),
        'created_at' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
        ),
        'updated_at' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
        ),
        'deleted_at',
    );

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

    protected static $_soft_delete = array(
        'mysql_timestamp' => false,
    );


    
    protected static $_table_name = 'blog_post';
    
    /**
     * Post BelongsTo Category
     * Post BelongsTo Author
     * 
     * @var array
     */
    protected static $_belongs_to = array(
        'category' => array(
            'key_from' => 'category_id',
            'model_to' => '\Rodasnet\Blog\Model\Category',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
        'author' => array(
            'key_from' => 'user_id',
            'model_to' => '\Rodasnet\Blog\Model\Author',
            'key_to' => 'id',
            'cascade_save' => false,
            'cascade_delete' => false,
        ),
    );

    /**
     * Post HasMany Comments
     * @var array
     * Post HasMany Galleries
     * @var array
     */
    protected static $_has_many = array(
        'comments' => array(
            'key_from' => 'id',
            'model_to' => '\Rodasnet\Blog\Model\Comment',
            'key_to' => 'post_id',
            'cascade_save' => false,
            'cascade_delete' => true,  // We delete all comments from the post deleted
        ),
        'galleries' => array(
            'key_from' => 'id',
            'model_to' => '\Media\Model_Gallery',
            'key_to' => 'post_id',
            'cascade_save' => false,
            'cascade_delete' => false,  // We do NOT delete all assests from the gallery deleted
        ),
    );

    public static function set_form_fields($form, $instance = null)
    {

        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);

        // Set authors
        foreach(Author::find('all') as $user)
            $form->field('user_id')->set_options($user->id, $user->username);

        // Set categories
        foreach(Category::find('all') as $category)
            $form->field('category_id')->set_options($category->id, $category->name);

    }    

}