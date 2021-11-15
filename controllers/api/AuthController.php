<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Exceptions\ForbiddenException;
use Project\Exceptions\NotFoundException;
use Project\JWT;
use Project\Models\UserModel;

#[JsonController('api/auth')]
class AuthController {

	#[Post('/login')]
	#[VerifyRequest(["email", "password"])]
	public function login(array $query): array {
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

	#[Post('/register')]
	#[VerifyRequest(["email", "password", "name",  "password", "firstname",  "birthdate",  "weight", "height"])]
	public function register(array $query): array {
		$query['password'] = password_hash($query['password'], PASSWORD_BCRYPT);

		if (UserModel::findBy("email", $query["email"]) != null)
			return ["error" => "Email already used"];
	
		$user = UserModel::create($query, 'm_');
		$user->save();

		unset($user->m_password);

		return [
			'success' => true,
			'user' => $user
		];
	}
}