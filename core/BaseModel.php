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

	private string $tableName;
	private array $columns = []; //["id", "DEFINITION"]
	private array $properties = []; //["id", "m_id"]

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
		// echo 'Syncing ' . $this->tableName . '...' . "\n";
		if (!$this->tableExist($pdo)) {
			$this->createTable($pdo);
			// echo 'Table ' . $this->tableName . ' created' . "\n";
		} else {
			if (Conf::$forceUpdate) {
				// echo 'Table ' . $this->tableName . ' force update, dropping table and recreating it...' . "\n";
				$this->dropTable($pdo);
				$this->createTable($pdo);
			}
				// echo 'Table ' . $this->tableName . ' already exists.' . "\n";
		}
	}

	/**
	 * This will save current entity into the database.
	 * If it exists it will update all the values
	 * If it doesn't exists it will insert the new entity into the database
	 */
	public function save(): BaseModel
	{
		$pdo = $GLOBALS["pdo"];
		$propsToModify = $this->properties;
		unset($propsToModify["id"]);
		$values = array_map(function ($property) {
			return $this->{$property};
		}, array_values($propsToModify));

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

	public function remove(): BaseModel
	{
		static::delete($this->m_id);
		return $this;
	}

	public function getCreationDate(): ?DateTime {
		return $this->m_date ? DateTime::createFromFormat(DateTime::ISO8601, $this->m_date) : null;
	}

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
		$pdo->query('CREATE TABLE ' . $this->tableName . ' (' . $sqlArgs . ')');
	}

	/**
	 * @param PDO $pdo
	 * Remove the table from the database.
	 */
	private function dropTable(PDO $pdo): void
	{
		$pdo->query('DROP TABLE ' . $this->tableName);
	}

	public static function create(array $data, string $prefix = ''): BaseModel
	{
		$instance = new static();
		foreach ($data as $key => $value)
			$instance->{$prefix . $key} = $value;
		return $instance;
	}
	/**
	 * @return array of models
	 **/
	public static function find(array $ids): array
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE id IN (?)');
		$query->execute(array(implode(',', $ids)));
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$models = array();
		foreach ($res as $data)
			array_push($models, static::create($data));
		return $models;
	}

	public static function findOne(int $id): ?BaseModel
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE id = ? LIMIT 1');
		$query->execute(array($id));
		$res = $query->fetch(PDO::FETCH_ASSOC);
		return !$res ? NULL : static::create($res, 'm_');
	}

	public static function delete(int $id)
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$pdo->prepare('DELETE FROM ' . $tableName . ' WHERE id = ?')->execute(array($id));
	}

	public static function exists(int $id): bool
	{
		return static::findOne($id) !== NULL;
	}

	private static function getTableName(): string
	{
		$el = new static();
		return $el->tableName;
	}
}
