<?php

namespace Project\Core;

use Exception;
use ReflectionClass;
use Project\Conf;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Exceptions\HttpException;
use Project\Utils;


/**
 * Controller manager
 * Handle all the controllers
 * @package Project\Core
 */
class ControllerManager
{

	/**
	 * List of routes
	 * @var Route[]
	 */
	private array $routes = [];

	public function __construct()
	{
		/**
		 * For each controllers we create a route and we put it in the routes list
		 */
		foreach (Conf::CONTROLLERS as $controller) {
			$classInfos = new ReflectionClass($controller);
			$controllerAttribute = $classInfos->getAttributes(Controller::class);
			if (!$controllerAttribute)
				$controllerAttribute = $classInfos->getAttributes(JsonController::class);
			$controllerAttribute = $controllerAttribute[0] ?? null;
			if (is_null($controllerAttribute))
				throw new Exception("ControllerManager: Controller '$controller' must have a #[Controller] or #[JsonController] Attribute");
			$rootPath = $this->parsePath($controllerAttribute->getArguments()[0] ?? '/');
			$isJson = $controllerAttribute->getName() == JsonController::class;
			$this->routes = array_merge($this->routes, $this->getControllerRoutes($classInfos, $rootPath, $isJson));
		}

		/**
		 * We initialize the database
		 */
		$modelManager = new ModelManager();
		$modelManager->verify();
		$modelManager->init();
	}

	/**
	 * This function is called by the main script and will handle the request
	 * If the path does not exists it returns a 404 error
	 * We merge all requests parameters (json body, files, get query or post request)
	 * Then we invoke the method to check the request, if it returns true. Then we invoke the main handling method
	 * If it is a json controller we encode the json response and we send it
	 * Otherwise we extract the variables and we include the view
	 */
	public function handleRequest()
	{
		$route = $this->getCurrentRoute();
		if (is_null($route)) {
			echo "404 Not found";
			http_response_code(404);
			return;
		}
		$controller = $route->function->getDeclaringClass()->newInstance();
		$entityBody = file_get_contents('php://input');
		$request = array_merge($_GET, $_POST, $_FILES, Utils::isJson($entityBody) ? json_decode($entityBody) : []);
		$headers = getallheaders();
		if (!$this->verifyRequest($request)) {
			http_response_code(400);
			return;
		}
		//We invoke the method to check the request, if it returns true. Then we invoke the main handling method
			try {
				$res = $route->function->invokeArgs($controller, [$request]);
				if (is_null($res)) {
					http_response_code(204);
					return;
				}
				if ($route->isJson)	//If the controller inherits from the json controller
					echo json_encode($res);
				else {
					if (array_key_exists(1, $res))
						extract($res[1]);
					$baseUrl = Conf::ROOT_PATH;
					include_once ROOT . "/views/$res[0].php";
				}
			} catch (HttpException $e) {	//We catch Http Exception to throw http errors
				http_response_code($e->getCode());
				if ($route->isJson)	//If the controller inherits from the json controller
					echo json_encode(["message" => $e->getMessage(), "code" => $e->getCode()]);
				else
					echo $e->getMessage();
			} catch (Exception $e) { //In case of a generic exception we throw a 500 error
				http_response_code(500);
				if ($route->isJson)	//If the controller inherits from the json controller
					echo json_encode(["message" => "Internal server error: " . $e->getMessage(), "code" => 500]);
				else
					echo "Internal server error: " . $e->getMessage();
			}
	}

	private function getRequestPath(): string
	{
		$path = str_replace(Conf::ROOT_PATH, "", strtok($_SERVER["REQUEST_URI"], '?'));
		if (str_ends_with($path, "/"))
			$path = substr($path, 0, strlen($path) - 1);
		return str_replace("//", "/", $path);
	}

	/**
	 * Will parse path in order to have the appropriate number of / before and after path
	 */
	private function parsePath(string $path): string
	{
		$fragments = explode("/", $path);
		$fragments = array_filter($fragments, function ($fragment) {
			return $fragment !== "";
		});
		return "/" . implode("/", $fragments);
	}

	private function getControllerRoutes(ReflectionClass $controller, string $rootPath, bool $isJson): array
	{
		$routeMethods = [];
		foreach ($controller->getMethods() as $method) {
			$attributes = $method->getAttributes();
			$routeAttr = array_filter($attributes, function ($attribute) {
				return in_array($attribute->getName(), Conf::ROUTE_ATTRIBUTES);
			})[0] ?? null;
			if (is_null($routeAttr))
				continue;
			$verifyAttr = $method->getAttributes(VerifyRequest::class)[0] ?? null;
			array_push($routeMethods, new Route(
				path: ($rootPath == "/" ? '' : $rootPath) . $this->parsePath($routeAttr->getArguments()[0]), 
				verifyArray: $verifyAttr ? $verifyAttr->getArguments()[0] ?? null : null,
				method: (new ReflectionClass($routeAttr->getName()))->getConstant("METHOD"),
				function:$method,
				isJson:$isJson
			));
		}
		return $routeMethods;
	}

	private function getCurrentRoute(): ?Route {
		$route = current(array_filter($this->routes, function ($route) {
			return $this->getRequestPath() == $route->path && $_SERVER["REQUEST_METHOD"] == $route->method;
		}));
		return $route ? $route : null;
	}

	private function verifyRequest(array $request): bool
	{
		$route = $this->getCurrentRoute();
		if (is_null($route->verifyArray))
			return true;
		return empty(array_filter(array_diff($route->verifyArray, array_keys($request))));
	}
}
