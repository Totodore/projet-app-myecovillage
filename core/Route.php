<?php

namespace Project\Core;

use ReflectionMethod;

class Route {

	public ReflectionMethod $function;
	public string $method;
	public string $path;
	public ?array $verifyArray;
	public bool $isJson;

	public function __construct(ReflectionMethod $function, string $method, string $path, ?array $verifyArray, bool $isJson) {
		$this->function = $function;
		$this->method = $method;
		$this->path = $path;
		$this->verifyArray = $verifyArray;
		$this->isJson = $isJson;
	}
}