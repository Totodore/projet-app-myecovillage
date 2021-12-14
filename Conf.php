<?php

/**
 * Project Configuration (ex: database credentials)
 */
namespace Project;

define('ROOT', dirname(__FILE__) . "/");

use PDO;
use Project\Controllers\AdminController;
use Project\Controllers\IndexController;
use Project\Controllers\Api\AuthController;
use Project\Controllers\Api\UserController;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\Put;
use Project\Core\Attributes\Http\Delete;
use Project\Core\Attributes\Http\Patch;
use Project\Models\UserModel;
use Project\Models\AdminMessageModel;
use Project\Models\HeartBeatModel;
use Project\Models\MinigameResultModel;
use Project\Models\FaqArticleModel;

class Conf
{

	const HOST = '127.0.0.1';
	const DB   = 'test';
	const USER = 'root';
	const PASS = 'root';
	const PORT = '3306';
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
		IndexController::class,
		AdminController::class,
		AuthController::class,
		UserController::class,
	];

	/**
	 * The list of all the models in the database
 	*/
	const MODELS = [
		UserModel::class,
		AdminMessageModel::class,
		HeartBeatModel::class,
		MinigameResultModel::class,
		FaqArticleModel::class,
	];

	const ROUTE_ATTRIBUTES = [
		Get::class,
		Post::class,
		Put::class,
		Patch::class,
		Delete::class,
	];

	const ROOT_PATH = "php-framework";
}
