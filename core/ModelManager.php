<?php

namespace Project\Core;

use Exception;
use PDO;
use Project\Conf;

/**
 * Class ModelManager
 * Class that manage all the models and the connexion to the database
 * @package Project\Core
 */
class ModelManager
{

	public $pdo;

	/**
	 * Verify that all the given models are valid
	 * They are not valid if the models dont inherit from the BaseModel class 
	 */
	public function verify()
	{
		/**
		 * @var BaseModel $model
		 */
		foreach (Conf::MODELS as $model)
			if (!is_subclass_of($model, BaseModel::class))
				throw new Exception('ModelManager: Model must be a subclass of BaseModel');
	}

	/**
	 * Initialize the connection to the database
	 * Synchronize the database with the models
	 */
	public function init(): void
	{
		try {
			$this->pdo = new PDO("mysql:host=" . Conf::HOST . ";port=3307;dbname=" . Conf::DB . ";charset=" . Conf::CHARSET, Conf::USER, Conf::PASS, Conf::OPTIONS);
		} catch (\PDOException $e) {
			echo $e;
			http_response_code(500);
			echo 'ModelManager: Could not connect to database';
			exit();
		}
		/**
		 * @var BaseModel $model
		 */
		foreach (Conf::MODELS as $model) {
			$instantiatedModel = new $model();
			$instantiatedModel->sync($this->pdo);
		}
		$GLOBALS['pdo'] = $this->pdo;
	}
}
