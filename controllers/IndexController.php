<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;

#[Controller]
class IndexController extends BaseController {

	#[Get('/')]
	public function index(array $query): array {
		return $this->loadView('index', $query);
	}
}