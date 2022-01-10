<?php

namespace Project;

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
use Project\Core\ControllerManager;
// use Project\Models\UserModel;

// $modelManager = new ModelManager();
// $modelManager->verify();
// $modelManager->init();

// $user = UserModel::create([
// 	'm_password' => 'blabla',
// 	'm_username' => 'Théodore',
// 	'm_email' => 'prevottheodore@gmail.com',
// ])->save();
// print_r($user);

// $user = UserModel::findOne(1);
// $user->m_username = 'Théodazdore';
// $user->save();
// $user->print();
// $user->remove();
// print_r(UserModel::findOne(345));


/**
 * Initialize dynamic parameters for PHP
 */
Conf::init();
/**
 * We create the controller manager and we ask it to handle the current request
 */
$controllerManager = new ControllerManager();
$controllerManager->handleRequest();