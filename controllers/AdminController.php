<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;

#[Controller("admin")]
class AdminController extends BaseController {

	#[Get("/index")]
	public function index(array $query): array {
		if (!$this->isAdmin())
			new ForbiddenException();
		return $this->loadView('admin/index', $query);
	}
}