<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\JWT;
use Project\Models\UserModel;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Core\BaseController;

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



	#[Post('edit_profil')]
	public function profil_edit(array $query): array 
	{
		$user = $this->getLoggedUser();

		$user->name = $query["nomchange"] ?? $user->name;

		$user->firstname = $query["prenomchange"] ?? $user->firstname;

		$user->height = $query["taillechange"] ?? $user->height;

		$user->weight = $query["poidschange"] ?? $user->weight;

		if($query["passwordchange"] != null)
		{
			$user->password = password_hash($query['passwordchange'], PASSWORD_BCRYPT);
		}

		$user->save();

		unset($user->password);

		return [
			'success' => true,
			'user' => $user
		];
		
	}
}