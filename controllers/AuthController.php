<?php

namespace Project\Controllers;

use Project\Conf;
use Project\Core\IGetController;
use Project\Core\IPostController;
use Project\Core\JsonController;
use Project\Exceptions\ForbiddenException;
use Project\Exceptions\NotFoundException;
use Project\JWT;
use Project\Models\UserModel;

class AuthController extends JsonController implements IPostController {

	public function verifyPostRequest(array $query): bool {
		return isset($array['email'], $array['password']);
	}

	public function postHandler(array $query): array {
		$user = UserModel::findBy("email", $query['email']);
		if (!$user)
			throw new NotFoundException("User not found");
		if (!password_verify($query['password'], $user->password))
			throw new ForbiddenException("Wrong password");

		unset($user["password"]);
		return [
			"token" => JWT::encode($user, Conf::JWT_SECRET)
		];
	}
}