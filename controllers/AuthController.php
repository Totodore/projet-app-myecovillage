<?php

namespace Project\Controllers;
use Project\Core\IGetController;
use Project\Core\IPostController;
use Project\Core\JsonController;

class AuthController extends JsonController implements IGetController, IPostController {

	public function verifyGetRequest(array $query): bool {
		return true;
	}

	public function getHandler(array $query): array {
		return ["index", $query];
	}

	public function verifyPostRequest(array $query): bool {
		return true;
	}

	public function postHandler(array $query): array {
		return ["index", $query];
	}
}