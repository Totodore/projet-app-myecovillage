<?php

namespace Project\Core;

use ReflectionClass;
use ReflectionProperty;
use PDO;
use PDOException;
use Project\Conf;
use DateTime;

/**
 * This is the base model class for all models.
 */
abstract class BaseModel
{

	/**
	 * The mysql table name
	 */
	private string $tableName;
	/**
	 * All the column in the table with their SQL definition
	 */
	private array $columns = []; //["id", "DEFINITION"]
	/**
	 * Mapping between the column name and the property name
	 */
	private array $properties = []; //["id", "m_id"]

	/**
	 * When the model is instantiated we fill the columns array with all the model properties
	 * We also set the table name from the model name
	 */
	public function __construct()
	{
		$reflection = new ReflectionClass($this);

		/**
		 * We get the class name and remove the "Model" suffix
		 */
		$this->tableName = $this->normalizeClassName($reflection->getName());
		/**
		 * @var $property ReflectionProperty
		 * For each property, if it starts with m_ we add it to the properties array
		 * We also add the column name to the columns array with the SQL definition
		 */
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
			if (str_starts_with($property->getName(), "m_")) {
				$columnName = substr($property->getName(), 2);
				$this->properties[$columnName] = $property->getName();
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
							$this->columns[$columnName] = 'BIGINT';
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
	 * If the table does not exsts we create it
	 * If we have to force update the table we recreate it
	 */
	public function sync(PDO $pdo): void
	{
		// echo 'Syncing ' . $this->tableName . '...' . "\n";
		if (!$this->tableExist($pdo)) {
			$this->createTable($pdo);
			// echo 'Table ' . $this->tableName . ' created' . "\n";
		} else {
			if (Conf::FORCE_UPDATE) {
				// echo 'Table ' . $this->tableName . ' force update, dropping table and recreating it...' . "\n";
				$this->dropTable($pdo);
				$this->createTable($pdo);
			}
				// echo 'Table ' . $this->tableName . ' already exists.' . "\n";
		}
	}

	/**
	 * This will save current model into the database.
	 * If it exists it will update all the values
	 * If it doesn't exists it will insert the new model into the database
	 */
	public function save(): BaseModel
	{
		//We get the reference of the database
		$pdo = $GLOBALS["pdo"];
		$propsToModify = $this->properties;
		//We remove the id property because we should not modify the id
		unset($propsToModify["id"]);
		//For each property we get the values
		$values = array_map(function ($property) {
			if (is_bool($this->{$property}))
				return $this->{$property} ? 1 : 0;
			else
				return $this->{$property};
		}, array_values($propsToModify));

		/**
		 * If there is an id specified in the model and that id exists in the database
		 * We update the model
		 * Else we add the new model to the database
		 * We return the created or updated model
		 */
		if (isset($this->m_id) && static::exists($this->m_id)) {
			$sqlPropsArg = implode(', ', array_map(function ($column) {
				return $column . ' = ?';
			}, array_keys($propsToModify)));
			$pdo->prepare('UPDATE ' . $this->tableName . ' SET ' . $sqlPropsArg . ' WHERE id = ?')->execute(array_merge($values, [$this->m_id]));
		} else {
			$sqlColumnsArgs = implode(', ', array_map(function ($column) {
				return $column === "id" ? 'NULL' : '?';
			}, array_keys($this->properties)));
			$sqlColumns = implode(', ', array_keys($this->properties));
			$pdo->prepare("INSERT INTO " . $this->tableName . " (" . $sqlColumns . ") VALUES (" . $sqlColumnsArgs . ")")->execute($values);
			foreach (get_object_vars(static::findOne(intval($pdo->lastInsertId()))) as $key => $value)
				$this->{$key} = $value;
		}
		return $this;
	}

	/**
	 * Method to remove the model from the database
	 */
	public function remove(): BaseModel
	{
		static::delete($this->m_id);
		return $this;
	}

	/**
	 * Method to get the creation date of the model from its date field
	 */
	public function getCreationDate(): ?DateTime {
		return $this->m_date ? DateTime::createFromFormat(DateTime::ISO8601, $this->m_date) : null;
	}

	/**
	 * Method to list all the properties with there values
	 */
	public function print(): void
	{
		$val = array();
		foreach ($this->properties as $key => $value)
			$val[$value] = $this->{$value};
		echo $this->tableName . ": ";
		print_r($val);
	}
	/**
	 * @param string $className
	 * @return string
	 * Normalize a class name to a table name.
	 */
	private function normalizeClassName(string $namespace): string
	{
		//We split the namespace by the backslash
		$classNameArray = explode('\\', $namespace);
		//We get the last element of the namespace (the classname) and we lowercase it
		$classNameArray = preg_split('/(?=[A-Z])/', end($classNameArray), -1, PREG_SPLIT_NO_EMPTY);
		//We put '_' between the classname words and we lowercase the whole string
		return strtolower(implode('_', array_slice($classNameArray, 0, -1)));
	}

	/**
	 * Check if the table already exist in the database.
	 */
	private function tableExist(PDO $pdo): bool
	{
		try {
			$pdo->query('SELECT 1 FROM ' . $this->tableName . ' LIMIT 1');
		} catch (PDOException) {
			return false;
		}
		return true;
	}

	/**
	 * @param PDO $pdo
	 * Create a table from the current model with all the columns and the primary key.
	 */
	private function createTable(PDO $pdo): void
	{
		$sqlArgArray = array_map(function ($columnName, $columnType) {
			return $columnName . ' ' . $columnType;
		}, array_keys($this->columns), array_values($this->columns));
		$sqlArgs = implode(', ', $sqlArgArray);
		$pdo->query('CREATE TABLE IF NOT EXISTS ' . $this->tableName . ' (' . $sqlArgs . ')');
	}

	/**
	 * @param PDO $pdo
	 * Remove the table from the database.
	 */
	private function dropTable(PDO $pdo): void
	{
		$pdo->query('DROP TABLE IF EXISTS ' . $this->tableName);
	}

	/**
	 * Create a model from an array of data
	 */
	public static function create(array $data, string $prefix = ''): BaseModel
	{
		$instance = new static();
		foreach ($data as $key => $value)
			$instance->{$prefix . $key} = $value;
		return $instance;
	}
	/**
	 * Find a list of models in the database from a list of ids
	 * If the list of ids is not specified it will returns all the models
	 * @return array of models
	 **/
	public static function find(?array $ids): array
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		if ($ids === null) {
			$query = $pdo->query('SELECT * FROM ' . $tableName);
			$query->execute();
		}
		else {
			$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE id IN (?)');
			$query->execute(array(implode(',', $ids)));
		}
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$models = array();
		foreach ($res as $data)
			array_push($models, static::create($data));
		return $models;
	}

	/**
	 * Find a model in the database from its id
	 */
	public static function findOne(int $id): ?BaseModel
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE id = ? LIMIT 1');
		$query->execute(array($id));
		$res = $query->fetch(PDO::FETCH_ASSOC);
		return !$res ? NULL : static::create($res, 'm_');
	}

	public static function findBy(string $column, string $value): ?BaseModel
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE ' . $column . ' = ? LIMIT 1');
		$query->execute(array($value));
		$res = $query->fetch(PDO::FETCH_ASSOC);
		return !$res ? NULL : static::create($res, 'm_');
	}

	/**
	 * Delete a model from the database from its id
	 */
	public static function delete(int $id)
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$pdo->prepare('DELETE FROM ' . $tableName . ' WHERE id = ?')->execute(array($id));
	}

	/**
	 * Check if a model exists in the database from its id
	 */
	public static function exists(int $id): bool
	{
		return static::findOne($id) !== NULL;
	}

	/**
	 * Get the table name
	 */
	private static function getTableName(): string
	{
		$el = new static();
		return $el->tableName;
	}
}
