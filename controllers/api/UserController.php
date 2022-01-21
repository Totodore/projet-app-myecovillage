<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\Delete;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\JWT;
use Project\Models\UserModel;
use Project\Core\Attributes\Http\Post;
use Project\Exceptions\BadRequestException;
use Project\Models\ForumModel;
use Project\Models\MinigameResultModel;
use Project\Models\TicketModel;

#[JsonController('api/users')]
class UserController extends BaseController
{

	#[Get('me')]
	public function getMe(): object
	{
		if (!$this->isLogged())
			throw new ForbiddenException();
		return JWT::decode($_SERVER['HTTP_AUTHORIZATION'], Conf::JWT_SECRET);
	}

	#[Get('all')]
	public function getAll(): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException();
		$users = UserModel::find(null, 100);
		foreach ($users as $user) {
			unset($user->password);
		}
		return $users;
	}

	#[Get('/search')]
	public function search(array $query)
	{
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
		if (!$this->isLogged())
			throw new ForbiddenException();
		$user = $this->getLoggedUser();

		$user->name = htmlspecialchars($query["nomchange"] ?? $user->name);

		$user->firstname = htmlspecialchars($query["prenomchange"] ?? $user->firstname);

		$user->height = htmlspecialchars($query["taillechange"] ?? $user->height);

		$user->weight = htmlspecialchars($query["poidschange"] ?? $user->weight);

		if ($query["passwordchange"] != null) {
			$user->password = password_hash($query['passwordchange'], PASSWORD_BCRYPT);
		}
		if ($query["mailchange"] != null && UserModel::findBy('email', $query["mailchange"]) == null) {
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

	#[Post('admin')]
	public function setAdmin(array $query): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException();
		if (!isset($query['id']))
			throw new BadRequestException('Missing id');
		$user = UserModel::findBy('id', $query['id']);
		$user->isadmin = $query['isadmin'] == 'true';
		$user->save();
		return [
			'success' => true,
			'user' => $user
		];
	}

	#[Delete('delete')]
	public function deleteUser(array $query): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException();
		if (!isset($query['id']))
			throw new BadRequestException('Missing id');
		$user = UserModel::findBy('id', $query['id']);
		TicketModel::deleteWHere('authorid', $user->id);
		TicketModel::deleteWHere('adminid', $user->id);
		ForumModel::deleteWHere('authorid', $user->id);
		MinigameResultModel::deleteWHere('userid', $user->id);
		$user->remove();
		return [
			'success' => true
		];
	}
}
