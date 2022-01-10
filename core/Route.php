<?php

namespace Project\Core;

use ReflectionAttribute;
use ReflectionMethod;

class Route {

	public ReflectionMethod $function;
	public string $method;
	public string $path;
	public ?array $verifyArray;
	public bool $isJson;
	public ?ReflectionAttribute $guard;

	public function __construct(ReflectionMethod $function, string $method, string $path, ?array $verifyArray, bool $isJson, ?ReflectionAttribute $guard) {
		$this->function = $function;
		$this->method = $method;
		$this->path = $path;
		$this->verifyArray = $verifyArray;
		$this->isJson = $isJson;
		$this->guard = $guard;
	}
}