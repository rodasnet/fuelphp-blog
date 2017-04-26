<?php

namespace Rodasnet\Blog;

class BlogException extends \FuelException {}

class Blog
{
	/**
	 * loaded instance
	 */
	protected static $_instance = null;

	/**
	 * array of loaded instances
	 */
	protected static $_instances = array();

	/**
	 * Default config
	 * @var array
	 */
	protected static $_defaults = array();

	/**
	 * Init
	 */
	public static function _init()
	{
	    \Config::load('blog', true);
	}

	/**
	 * Rnblog driver forge.
	 *
	 * @param	string			$instance		Instance name
	 * @param	array			$config		Extra config array
	 * @return  Rnblog instance
	 */
	public static function forge($instance = 'default', $config = array())
	{

		is_array($config) or $config = array('driver' => $config);

		$config = \Arr::merge(static::$_defaults, \Config::get('blog', array()), $config);

		$class = '\Rodasnet\\Blog\\' . ucfirst(strtolower($config['driver']));

		if( ! class_exists($class, true))
		{
			throw new \FuelException('Could not find Rnblog driver: ' . ucfirst(strtolower($config['driver'])));
		}

		$driver = new $class($config);

		static::$_instances[$instance] = $driver;

		return $driver;
	}

	/**
	 * Return a specific driver, or the default instance (is created if necessary)
	 *
	 * @param   string  $instance
	 * @return  Rnblog instance
	 */
	public static function instance($instance = null)
	{
		if ($instance !== null)
		{
			if ( ! array_key_exists($instance, static::$_instances))
			{
				return false;
			}

			return static::$_instances[$instance];
		}

		if (static::$_instance === null)
		{
			static::$_instance = static::forge();
		}

		return static::$_instance;
	}
}
