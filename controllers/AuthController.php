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
		return isset($query["email"], $query["password"]);
	}

	public function postHandler(array $query): array {
		$user = UserModel::findBy("email", $query['email']);
		if (!$user)
			throw new NotFoundException("User not found");
		if (!password_verify($query['password'], $user->m_password))
			throw new ForbiddenException("Wrong password");

		unset($user->m_password);
		return [
			"token" => JWT::encode(get_object_vars($user), Conf::JWT_SECRET)
		];
	}
}