<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\JWT;
use Project\Models\UserModel;
use Project\Core\Attributes\Http\Post;

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
		if (!$this->isLogged())
			throw new ForbiddenException();
		$users = UserModel::search($query["query"], ['firstname', 'name', 'email'], 5);
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
		if ($query["mailchange"] != null && UserModel::findBy('email', $query["mailchange"]) == null)
		{
			$user->email = $query["mailchange"];
		}
		
		$user->save();
		$this->sendMail($user->email, "Modification de votre profil", "Bonjour,\n\nVotre profil a été modifié.\n\nCordialement,\nL'équipe MyEcovillage");

		unset($user->password);

		return [
			'success' => true,
			'user' => $user
		];
		
	}
}