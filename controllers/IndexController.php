<?php

namespace Project\Controllers;

class IndexController extends BaseController implements IGetController {

	public function verifyGetRequest(array $query): bool {
		return true;
	}

	public function getHandler(array $query): array {
		print_r($query);
		return ["index", $query];
	}
}