<?php

namespace Project\Controllers;
use Project\Core\BaseController;
use Project\Core\IGetController;

class IndexController extends BaseController implements IGetController {

	public function verifyGetRequest(array $query): bool {
		return true;
	}

	public function getHandler(array $query): array {
		return ["index", $query];
	}
}