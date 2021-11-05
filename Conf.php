<?php

/**
 * Project Configuration (ex: database credentials)
 */
namespace Project;

define('ROOT', dirname(__FILE__) . "/");

use PDO;
use Project\Controllers\AdminController;
use Project\Controllers\IndexController;
use Project\Controllers\AuthController;
use Project\Controllers\RegisterController;
use Project\Models;

class Conf
{

	const HOST = '127.0.0.1';
	const DB   = 'test';
	const USER = 'root';
	const PASS = 'root';
	const CHARSET = 'utf8mb4';
	const FORCE_UPDATE = false;
	const JWT_SECRET = "PNkL4zCwxmP34SN8mhQNuqLijoq8X9zocsbJnzUzXLOXWDbXL8m67B0vYBgyKoH1";
	const OPTIONS = [
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
		"/api/auth" => AuthController::class,
		'/api/register' => RegisterController::class
	];

	/**
	 * The list of all the models in the database
 	*/
	const MODELS = [
		Models\UserModel::class,
		Models\AdminMessageModel::class,
		Models\HeartBeatModel::class,
		Models\MinigameResultModel::class,
		Models\FaqArticleModel::class,
	];

	const ROOT_PATH = "php-framework";
}
