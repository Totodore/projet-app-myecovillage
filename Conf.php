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
use Project\Controllers\Api\ContactController;
use Project\Controllers\Api\TicketController;
use Project\Controllers\Api\UserController;
use Project\Controllers\InfoController;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\Put;
use Project\Core\Attributes\Http\Delete;
use Project\Core\Attributes\Http\Patch;
use Project\Models\UserModel;
use Project\Models\HeartBeatModel;
use Project\Models\MinigameResultModel;
use Project\Models\FaqArticleModel;
use Project\Models\ForumModel;
use Project\Models\TicketModel;

class Conf
{

	//DB Configuration
	const DB_HOST 						= '127.0.0.1';
	const DB_NAME   					= 'test';
	const DB_USER 						= 'root';
	const DB_PASS 						= 'root';
	const DB_PORT 						= '3306';
	const DB_CHARSET 					= 'utf8mb4';
	const DB_FORCE_UPDATE 		= false;
	const OPTIONS = [
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
		PDO::ATTR_EMULATE_PREPARES   => false,
	];
	
	//Mail configuration
	const MAIL_PASSWORD 	= 'dabEscPNSr';
	const MAIL_USER 			= 'jasiewe21@gmail.com';
	const MAIL_HOST 			= 'mail.scriptis.fr';
	const MAIL_PORT 			= '587';
	const MAIL_FROM_NAME 	= 'MyEcoVillage';
	
	const MAPS_API_KEY		= "AIzaSyBKYOtiKQz6F8OCE6iQ8mM8GqWxFq_4ouQ";

	//Security configuration
	const JWT_SECRET 			= "PNkL4zCwxmP34SN8mhQNuqLijoq8X9zocsbJnzUzXLOXWDbXL8m67B0vYBgyKoH1";

	/**
	 * The list of the controllers with their corresponding routes
	 */
	const CONTROLLERS = [
		IndexController::class,
		InfoController::class,
		AdminController::class,
		AuthController::class,
		UserController::class,
		ContactController::class,
		TicketController::class
	];

	/**
	 * The list of all the models in the database
 	*/
	const MODELS = [
		UserModel::class,
		HeartBeatModel::class,
		MinigameResultModel::class,
		FaqArticleModel::class,
		ForumModel::class,
		TicketModel::class,
	];

	/**
	 * The list of possible route attributes
	 */
	const ROUTE_ATTRIBUTES = [
		Get::class,
		Post::class,
		Put::class,
		Patch::class,
		Delete::class,
	];

	const ROOT_PATH = "php-framework";

	/**
	 * Get an environment variable from $_SERVER or $_ENV or return null if it does not exist
	 * @return string|null the environment variable or null if not found
	 */
	public static function getenv(string $key): ?string {
		if (!getenv($key))
			return null;
		else
			return getenv($key);
	}

	/**
	 * Get a configuration value from env variables or from the configuration file
	 * @return string|null null in case of no value
	 */
	public static function get(string $key): ?string {
		if (Conf::getenv($key) == null)
			return constant('Project\Conf::'.$key);
		else
			return Conf::getenv($key);
	}

	public static function init(): void {
	}
}
