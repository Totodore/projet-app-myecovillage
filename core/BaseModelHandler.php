<?php

namespace Project\Core;

use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use ReflectionClass;
use ReflectionProperty;

abstract class BaseModelHandler
{


	/**
	 * The mysql table name
	 */
	protected string $tableName;
	/**
	 * All the column in the table with their SQL definition
	 * @var ColumnMetadata[]
	 */
	protected array $columns = [];

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
		 * We also add the column name to the columns array with the SQL definition
		 */
		foreach ($reflection->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
			$isDecorated = $property->getAttributes(PrimaryColumn::class) != null || $property->getAttributes(Column::class) != null;
			if ($isDecorated)
				array_push($this->columns, new ColumnMetadata($property, $this));
		}
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

	protected function getColumnDefinitions(): array {
		return array_values(
			array_map(function($column) { return $column->getDefinition(); }, $this->columns)
		);
	}

	protected function getColumnNames($excludeId = false): array {
		return array_values(array_map(function($column) { return $column->getName(); }, 
			array_filter($this->columns, function($column) use(&$excludeId) { return !$column->isPrimaryKey || !$excludeId; })
		));
	}

	protected function getColumnValues($excludeId = false): array {
		return array_values(array_map(function($column) { return $column->getValue(); }, 
			array_filter($this->columns, function($column) use(&$excludeId) { return !$column->isPrimaryKey || !$excludeId; })
		));
	}

	protected function getColumnEntries($excludeId = false): array {
		$arr = [];
		foreach ($this->columns as $column) {
			if (!$column->isPrimaryKey || !$excludeId)
				$arr[$column->getName()] = $column->getValue();
		}
		return $arr;
	}

	protected function getPrimaryColumnValue(): ?int {
		return array_filter($this->columns, function($column) { return $column->isPrimaryKey; })[0]->getValue() ?? null;
	}
}
