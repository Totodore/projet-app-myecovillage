<?php

namespace Project\Controllers;

class IndexController extends BaseController implements IGetController {

	public function verifyGetRequest(array $query): bool {
		return true;
	}

	public function getHandler(array $query): array {
		return ["index", $query];
	}
}