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

	}

	/**
	 * Rnblog driver forge.
	 *
	 * @param	string			$instance		Instance name
	 * @param	array			$config		Extra config array
	 * @return  Blog instance
	 */
	public static function forge($instance = 'default', $apiDriver = 'default')
	{
		$config = file(__DIR__ . '/config/blog.php');

        $apiDriver == 'default' ? $apiDriver = 'Rodasnet' : $apiDriver;

        $class = '\Rodasnet\\Blog\\Api\\' . ucfirst(strtolower($apiDriver));

        if( ! class_exists($class, true))
        {
            throw new \FuelException('Could not find Rodasnet\Blog driver: ' . ucfirst(strtolower($apiDriver)));
        }

		if( ! class_exists($class, true))
		{
			throw new \FuelException('Could not find Rnblog driver: ' . ucfirst(strtolower($apiDriver)));
		}

		$driver = new $class($config);

		static::$_instances[$instance] = $driver;

		return $driver;
	}

	/**
	 * Return a specific driver, or the default instance (is created if necessary)
	 *
	 * @param   string  $instance
	 * @return  Blog instance
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
