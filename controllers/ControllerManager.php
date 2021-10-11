<?php

namespace Project\Controllers;

use Exception;
use ReflectionClass;
use Project\Conf;
use Project\Utils;

class ControllerManager
{
	const CONTROLLERS = [
		"/" => IndexController::class,
		"/admin" => AdminController::class,
	];

	private $routes = []; // [GET /Path/To/route, [Verify method ref, Method ref, isJson]] 

	public function __construct() {
		foreach (self::CONTROLLERS as $route => $controller) {
			if (!is_subclass_of($controller, BaseController::class))
				throw new Exception('ControllerManager: Controller must be a subclass of BaseController');
			$classInfos = new ReflectionClass($controller);
			$implementations = class_implements($controller);
			if (in_array(IGetController::class, $implementations))
				$this->routes['GET '.$route] = [$classInfos->getMethod('verifyGetRequest'), $classInfos->getMethod('getHandler'), is_subclass_of($controller, JsonController::class)];
			if (in_array(IPostController::class, $implementations))
				$this->routes['POST '.$route] = [$classInfos->getMethod('verifyPostRequest'), $classInfos->getMethod('postHandler'), is_subclass_of($controller, JsonController::class)];
			if (in_array(IPatchController::class, $implementations))
				$this->routes['PATCH '.$route] = [$classInfos->getMethod('verifyPatchRequest'), $classInfos->getMethod('patchHandler'), is_subclass_of($controller, JsonController::class)];
			if (in_array(IPutController::class, $implementations))
				$this->routes['PUT '.$route] = [$classInfos->getMethod('verifyPutRequest'), $classInfos->getMethod('putHandler'), is_subclass_of($controller, JsonController::class)];
			if (in_array(IDeleteController::class, $implementations))
				$this->routes["DELETE ".$route] = [$classInfos->getMethod('verifyDeleteRequest'), $classInfos->getMethod('deleteHandler'), is_subclass_of($controller, JsonController::class)];
		}
	}

	public function handleRequest() {
		$path = $this->getRequestPath();
		$key = "$_SERVER[REQUEST_METHOD] $path";
		$controllerType = self::CONTROLLERS[$path];
		$controller = new $controllerType();
		$entityBody = file_get_contents('php://input');
		$request = array_merge($_GET, $_POST, $_FILES, Utils::isJson($entityBody) ? json_decode($entityBody) : []);
		//We invoke the method to check the request, if it returns true. Then we invoke the main handling method
		if ($this->routes[$key][0]->invokeArgs($controller, [$request])) {
			$res = $this->routes[$key][1]->invokeArgs($controller, [$request]);
			if (!$res)
				http_response_code(204);
			if ($this->routes[$key][2])	//If the controller inherits from the json controller
				echo json_encode($res);
			else {
				include_once ROOT."/views/$res[0].php";
			}
		}
		else {
			http_response_code(400);
			return;
		}
	}

	private function getRequestPath(): string {
		$path = str_replace(Conf::ROOT_PATH, "", strtok($_SERVER["REQUEST_URI"], '?'));
		return str_replace("//", "/", $path);
	}
}
