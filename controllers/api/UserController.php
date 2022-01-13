<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\JWT;
use Project\Models\UserModel;

#[JsonController('api/users')]
class UserController extends BaseController {

	#[Get('me')]
	public function getMe(): object {
		return JWT::decode($_SERVER['HTTP_AUTHORIZATION'], Conf::JWT_SECRET);
	}

	#[Get('all')]
	public function getAll(): array {
		$users = UserModel::find();
		foreach ($users as $user) {
			unset($user->password);
		}
		return $users;
	}

	#[Get('/search')]
	public function search(array $query) {
		// if (!$this->isLogged())
		// 	throw new ForbiddenException();
		$users = UserModel::search($query["query"], ['firstname', 'name', 'email'], 5);
		foreach ($users as $user) {
			unset($user->password);
		}
		return $users;
	}
}