<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;

#[Controller]
class AdminController extends BaseController {

	#[Get("/admin")]
	public function index(array $query): array {
		print_r($query);
		return $this->loadView('admin.index', $query);
	}
}