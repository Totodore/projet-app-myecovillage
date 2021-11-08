<?php

namespace Project\Controllers;
use Project\Core\Attributes\Controller;
use Project\Core\Attributes\Get;

#[Controller]
class IndexController {

	#[Get('/')]
	public function index(array $query): array {
		return ["index", $query];
	}
}