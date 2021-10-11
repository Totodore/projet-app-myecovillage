<?php

namespace Project\Models {

	use Exception;
	use PDO;
	use Project\Conf;

	class ModelManager
	{

		public $pdo;

		/**
		 * @var models BaseModel[]
		 */
		private array $models = array(
			UserModel::class
		);

		public function verify() {
			/**
			 * @var BaseModel $model
			 */
			foreach ($this->models as $model)
				if (!is_subclass_of($model, BaseModel::class))
					throw new Exception('ModelManager: Model must be a subclass of BaseModel');
		}

		public function init()
		{
			try {
				$this->pdo = new PDO("mysql:host=".Conf::$host.";dbname=".Conf::$db.";charset=".Conf::$charset, Conf::$user, Conf::$pass, Conf::$options);
			} catch (\PDOException $e) {
				echo ($e);
				throw new Exception('ModelManager: Could not connect to database');
			}
			/**
			 * @var BaseModel $model
			 */
			foreach ($this->models as $model) {
				$instantiatedModel = new $model();
				$instantiatedModel->sync($this->pdo);
			}
		}
	}
}
