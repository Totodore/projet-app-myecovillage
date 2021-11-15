<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\JWT;
use Project\Models\UserModel;

#[JsonController('api/users')]
class UserController {

	#[Get('me')]
	public function getMe(): array {
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
}