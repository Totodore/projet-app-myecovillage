<?php

/**
 * Project Configuration (ex: database credentials)
 */
namespace Project;

define('ROOT', dirname(__FILE__) . "/");

use PDO;
use Project\Controllers\AdminController;
use Project\Controllers\IndexController;

class Conf
{

	static string $host = '127.0.0.1';
	static string $db   = 'test';
	static string $user = 'root';
	static string $pass = 'root';
	static string $charset = 'utf8mb4';
	static bool $forceUpdate = true;
	static array $options = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];

	/**
	 * The list of the controllers with their corresponding routes
	 */
	const CONTROLLERS = [
		"/" => IndexController::class,
		"/admin" => AdminController::class,
	];

	const ROOT_PATH = "php-framework";
}
