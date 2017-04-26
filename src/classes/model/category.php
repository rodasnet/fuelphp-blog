<?php
namespace Rnblog\Model;

class Category extends \Orm\Model_Soft
{
    protected static $_properties = array(
        'id',
        'parent_id' => array(
            'label' => 'backend.category.parent_id',
            'form' => array('type' => 'select'),
            'null' => true,
//            'validation' => array('is_numeric'),
        ),
        'name' => array(
            'label' => 'Name',
            'default' => '',
            'null' => false,
            'validation' => array('required', 'min_length' => array(3)),
        ),
        'slug' => array(
            'label' => 'Slug',
            'default' => '',
            'null' => false,
            'validation' => array('required'),
        ),
        'post_count' => array(
            'form' => array('type' => false),
            'default' => 0,
            'null' => false,
            // Validation does not  passs in the action_add controller method
//            'validation' => array('is_numeric'),
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
        'order_by' => array('name' => 'asc'),
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

    protected static $_table_name = 'blog_category';
    
    /**
     * Category HasMany Posts
     * 
     * @var array
     */
    protected static $_has_many = array(
        'posts' => array(
            'key_from' => 'id',
            'model_to' => '\Rnblog\Model\Post',
            'key_to' => 'category_id',
            'cascade_save' => false,
            'cascade_delete' => false,  // We delete all post from the category deleted
        ),
    );

    public static function set_form_fields($form, $instance = null)
    {
        // Call parent for create the fieldset and set default value
        parent::set_form_fields($form, $instance);

        // Add null value for parent categories.
        $form->field('parent_id')->set_options('null','None');

        $categories = Category::find('all', array(
        'where' => array(
            array('parent_id', null)
        )
        ));

        // Set categories
        foreach($categories as $category)
            $form->field('parent_id')->set_options($category->id, $category->name);

    }
}