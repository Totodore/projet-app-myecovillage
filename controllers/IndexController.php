<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\AuthGuard;
use Project\Core\BaseController;
use Project\Models\UserModel;

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
	#[Get('/faq')]
	public function faq(array $query): array {
		return $this->loadView('faq', $query);
	}
	
	#[Get('/contactus')]
	public function contactus(array $query): array {
		return $this->loadView('contactus', $query);
	}

	#[Get('/account')]
	public function account(array $query): array {
		$user = UserModel::findOne(10); 
		return $this->loadView('account', [ "user" => $user ]);
	}

	#[Get('/account/edit')]
	public function account_edit(array $query): array {
		$usered = UserModel::findOne(10);
		return $this->loadView('account_edit', [ "usered" => $usered ]);
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