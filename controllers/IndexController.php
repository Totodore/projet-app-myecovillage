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

	#[Get('/home')]
	public function home(array $query): array {
		return $this->loadView('home', $query);
	}

	#[Get('/signin')]
	public function signin(array $query): array {
		return $this->loadView('signin', $query);
	}

	#[Get('/signup')]
	public function signup(array $query): array {
		return $this->loadView('signup', $query);
	}
	#[Get('/cgu')]
	public function cgu(array $query): array {
		return $this->loadView('cgu', $query);
	}
	#[Get('/forum')]
	public function forum(array $query): array {
		return $this->loadView('forum', $query);
	}
	#[Get('/gestion_forum')]
	public function gestion_forum(array $query): array {
		return $this->loadView('gestion_forum', $query);
	}
}