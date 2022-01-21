<?php

namespace Project\Core;

use PDO;
use PDOException;
use Project\Conf;
use DateTime;

/**
 * This is the base model class for all models.
 */
abstract class BaseModel extends BaseModelHandler
{

	/**
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
			if (Conf::get("DB_FORCE_UPDATE")) {
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
		//For each property we get the values
		$columnNames = $this->getColumnNames(excludeId: true);
		$columnValues = $this->getColumnValues(excludeId: true);
		$id = $this->getPrimaryColumnValue();
		/**
		 * If there is an id specified in the model and that id exists in the database
		 * We update the model
		 * Else we add the new model to the database
		 * We return the created or updated model
		 */
		if ($id != null && static::exists($id)) {
			$sqlPropsArg = implode(', ', array_map(function($name) { return $name . ' = ?'; }, $columnNames));
			$pdo->prepare('UPDATE ' . $this->tableName . ' SET ' . $sqlPropsArg . ' WHERE id = ?')->execute(array_merge($columnValues, [$id]));
		} else {
			$sqlColumnsArgs = implode(', ', array_map(function ($name) { return $name === "id" ? 'NULL' : '?'; }, $this->getColumnNames()));
			$sqlColumns = "id, ".implode(', ', $columnNames);
			$pdo->prepare("INSERT INTO " . $this->tableName . " (" . $sqlColumns . ") VALUES (" . $sqlColumnsArgs . ")")->execute($columnValues);
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
		static::delete($this->getPrimaryColumnValue());
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
		foreach ($this->getColumnEntries() as $key => $value)
			$val[$key] = $value;
		echo $this->getTableName() . ": ";
		print_r($val);
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
		/**
		 * @param ColumnMetadata $column
		 */
		$definitions = $this->getColumnDefinitions();
		$definitionStr = implode(', ', $definitions);
		// print_r($definitions);
		$pdo->query('CREATE TABLE IF NOT EXISTS ' . $this->tableName . ' (' . $definitionStr . ')');
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
	public static function create(array $data): BaseModel
	{
		$instance = new static();
		$types = $instance->getColumnTypes();
		foreach ($data as $key => $value) {
			if (!array_key_exists($key, $types))
				continue;
			$instance->{$key} = $types[$key] === 'DATETIME' ? new DateTime($value) : $value;
		}
		return $instance;
	}
	/**
	 * Find a list of models in the database from a list of ids
	 * If the list of ids is not specified it will returns all the models
	 * @return array of models
	 **/
	public static function find(?array $ids = null, ?int $limit = null): array
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		if ($ids === null) {
			$query = $pdo->query('SELECT * FROM ' . $tableName . ($limit ? ' LIMIT ' . $limit : ''));
			$query->execute();
		}
		else {
			$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE id IN (?)' . ($limit ? ' LIMIT ' . $limit : ''));
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
		return !$res ? NULL : static::create($res);
	}

	public static function findBy(string $column, string $value): ?BaseModel
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE ' . $column . ' = ? LIMIT 1');
		$query->execute(array($value));
		$res = $query->fetch(PDO::FETCH_ASSOC);
		return !$res ? NULL : static::create($res);
	}

	public static function findManyBy(string $column, string $value): ?array
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare('SELECT * FROM ' . $tableName . ' WHERE ' . $column . ' = ?');
		$query->execute(array($value));
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		if ($res == null)
			return NULL;
		return array_map(function ($data) {
			return static::create($data);
		}, $res);
	}

	public static function search(string $q, array $columns, int $limit): array
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$query = $pdo->prepare("SELECT * FROM $tableName WHERE " . implode("OR ", array_map(function($col) { return " UPPER($col) LIKE UPPER(?) "; }, $columns)) . " LIMIT ?");
		$query->execute(array_merge(array_fill(0, count($columns), '%' . $q . '%'), [$limit]));
		$res = $query->fetchAll(PDO::FETCH_ASSOC);
		$models = array();
		foreach ($res as $data)
			array_push($models, static::create($data));
		return $models;
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

	public static function deleteWHere(string $column, string $value)
	{
		$tableName = static::getTableName();
		$pdo = $GLOBALS['pdo'];
		$pdo->prepare('DELETE FROM ' . $tableName . ' WHERE ' . $column . ' = ?')->execute(array($value));
	}

	/**
	 * Check if a model exists in the database from its id
	 */
	public static function exists(int $id): bool
	{
		return static::findOne($id) != NULL;
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
