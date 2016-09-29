<?php

Autoloader::add_core_namespace('Rnblog');

Autoloader::add_classes(array(
	'Rnblog\\Rnblog' => __DIR__ . '/classes/rnblog.php',
	'Rnblog\\RnblogException' => __DIR__ . '/classes/rnblog.php',

	'Rnblog\\Rnblog_Driver' => __DIR__ . '/classes/rnblog/driver.php',
	'Rnblog\\Rnblog_Rodasnet' => __DIR__ . '/classes/rnblog/rodasnet.php',
	'Rnblog\\Rnblog_Wordpress' => __DIR__ . '/classes/rnblog/wordpress.php',

    // Models
	'Rnblog\\Model\Author' => __DIR__ . '/classes/model/author.php',
	'Rnblog\\Model\Author\Metadata' => __DIR__ . '/classes/model/author/metadata.php',
	'Rnblog\\Model\Comment' => __DIR__ . '/classes/model/comment.php',
	'Rnblog\\Model\Post' => __DIR__ . '/classes/model/post.php',
	'Rnblog\\Model\Category' => __DIR__ . '/classes/model/category.php',
));
