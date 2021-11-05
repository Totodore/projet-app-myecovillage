<?php

namespace Project\Controllers;

use Project\Core\JsonController;
use Project\Core\IPostController;
use Project\Models\UserModel;

class RegisterController extends JsonController implements IPostController
{
	public function verifyPostRequest(array $query): bool {
		return isset($query['name'], $query['password'], $query['email'], $query['name'], $query['firstname'], $query['birthdate'], $query['weight'], $query['height']);
	}

	public function postHandler(array $query): array {
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