<?php

namespace Project\Models {

	use ReflectionClass;
	use ReflectionProperty;
	use PDO;
	use PDOException;
	use Project\Conf;

	/**
	 * This is the base model class for all models.
	 */
	abstract class BaseModel
	{

		private string $tableName;
		private array $columns = [];

		/**
		 * When the model is instantiated we fill the columns array with all the model properties
		 * We also set the table name from the model name
		 */
		public function __construct()
		{
			$reflection = new ReflectionClass($this);
			
			$this->tableName = $this->normalizeClassName($reflection->getName());
			/**
			 * @var $property ReflectionProperty
			 */
			foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
				if (str_starts_with($property->getName(), "m_")) {
					$columnName = substr($property->getName(), 2);
					if ($columnName === 'id') {
						$this->columns['id'] = 'BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
					} else {
						switch ($property->getType()->getName()) {
							case 'string':
								$this->columns[$columnName] = 'VARCHAR(255)';
								break;
							case 'bool':
								$this->columns[$columnName] = 'TINYINT(1)';
								break;
							case 'int':
								$this->columns[$columnName] = 'INT';
								break;
							default: 
								break;
						}
					}
				}
			}
		}

		/**
		 * @return void
		 * Synchronize the model with the database
		 */
		public function sync(PDO $pdo): void
		{
			echo 'Syncing '.$this->tableName.'...'."\n";
			if (!$this->tableExist($pdo)) {
				$this->createTable($pdo);
				echo 'Table '.$this->tableName.' created'."\n";
			} else {
				if (Conf::$forceUpdate) {
					echo 'Table '.$this->tableName.' force update, dropping table and recreating it...'."\n";
					$this->dropTable($pdo);
					$this->createTable($pdo);
				} else
					echo 'Table '.$this->tableName.' already exists.'."\n";
			}
		}

		/**
		 * @param string $className
		 * @return string
		 * Normalize a class name to a table name.
		 */
		private function normalizeClassName(string $namespace): string {
			//We split the namespace by the backslash
			$classNameArray = explode('\\', $namespace);
			//We get the last element of the namespace (the classname) and we lowercase it
			$classNameArray = preg_split('/(?=[A-Z])/', end($classNameArray), -1, PREG_SPLIT_NO_EMPTY);
			return strtolower(implode('_', array_slice($classNameArray, 0, -1)));
		}

		/**
		 * Check if the table already exist in the database.
		 */
		private function tableExist(PDO $pdo): bool {
			try {
				$pdo->query('SELECT 1 FROM '.$this->tableName.' LIMIT 1');
			} catch(PDOException) {
				return false;
			}
			return true;
		}

		/**
		 * @param PDO $pdo
		 * Create a table from the current model with all the columns and the primary key.
		 */
		private function createTable(PDO $pdo): void {
			$sqlArgArray = array_map(function($columnName, $columnType) {
				return $columnName.' '.$columnType;
			}, array_keys($this->columns), array_values($this->columns));
			$sqlArgs = implode(', ', $sqlArgArray);
			$pdo->query('CREATE TABLE '.$this->tableName.' ('.$sqlArgs.')');
		}

		/**
		 * @param PDO $pdo
		 * Remove the table from the database.
		 */
		private function dropTable(PDO $pdo): void {
			$pdo->query('DROP TABLE '.$this->tableName);
		}
	}
}
