<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\JWT;
use Project\Models\UserModel;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\VerifyRequest;

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



	#[Post('edit_profil')]
	#[VerifyRequest(["email", "password", "name",  "password", "firstname",  "birthdate",  "weight", "height"])]
	public function register(array $query): array {
		$query['password'] = password_hash($query['password'], PASSWORD_BCRYPT);

		/*if (UserModel::findBy("email", $query["email"]) != null)
			return ["error" => "Email already used"];
		*/
		$user = UserModel::findOne(10);
		$user->save();

		unset($user->password);

		return [
			'success' => true,
			'user' => $user
		];
		
	}
}