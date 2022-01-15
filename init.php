<?php

namespace Project;

use ErrorException;
use Exception;
/**
 * Options to display all errors
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * PHP autoloader
 * This function will autoload classes from given namespace
 * @param string $className The namespace class to load
 * @return void
 * @throws Exception if class is not found
 */
spl_autoload_register(function (string $className) {
	$rootNamespace = 'Project';

	//We split the namespace by the namespace separator
	$namespace = explode('\\', $className);
	if ($namespace[0] !== $rootNamespace)
		throw new Exception('Class name is not in namespace Project: ' . $className);
	$className = end($namespace);
	$namespace = array_slice($namespace, 1, -1);
	$relativePath = trim(strtolower(str_replace('\\', '/', implode('/', $namespace))), '/');
	$path = __DIR__ . '/' . ($relativePath ? $relativePath . '/' : '') . $className . '.php';
	if (file_exists($path)) {
		require_once $path;
	}
	else {
		throw new Exception('Class ' . $className . ' not found, required path: ' . $path);
	}
});

set_error_handler(function ($errno, $errstr, $errfile, $errline ) {
	throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
});

use Project\Core\ControllerManager;
/**
 * Initialize dynamic parameters for PHP
 */
Conf::init();
/**
 * We create the controller manager and we ask it to handle the current request
 */
$controllerManager = new ControllerManager();
$controllerManager->handleRequest();