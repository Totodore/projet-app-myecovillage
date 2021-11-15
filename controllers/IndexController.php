<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;

#[Controller]
class IndexController {

	#[Get('/')]
	public function index(array $query): array {
		return ["index", $query];
	}
}