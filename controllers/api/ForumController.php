<?php

namespace Project\Controllers\Api;

use DateTime;
use Project\Core\Attributes\Http\Delete;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\Put;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Exceptions\NotFoundException;
use Project\Models\ForumModel;

#[JsonController('api/forum')]
class ForumController extends BaseController
{

	#[Post('/add')]
	#[VerifyRequest(["question"])]
	public function contactus(array $query): array
	{
		if (!$this->isLogged())
			throw new ForbiddenException("Vous devez être connecté pour pouvoir poster un message");

		$forum = ForumModel::create($query);
		$forum->authorid = $this->getLoggedUser()->id;
		$forum->date = new DateTime();
		$forum->save();

		return ["forum" => $forum];
	}

	#[Put('/answer')]
	#[VerifyRequest(["answer", "id"])]
	public function answer(array $query): array
	{
		if (!$this->isLogged())
			throw new ForbiddenException("Vous devez être connecté pour pouvoir poster un message");
		$forum = ForumModel::findOne($query["id"]);
		if (!$forum)
			throw new NotFoundException("Le message n'existe pas");
		if ($forum->answerid)
			throw new ForbiddenException("Le message a déjà été répondu");
		$forum->answer = $query["answer"];
		$forum->answerid = $this->getLoggedUser()->id;
		$forum->answerDate = new DateTime();
		$forum->save();
		return ["forum" => $forum];
	}

	#[Delete('/delete')]
	#[VerifyRequest(["id"])]
	public function delete(array $query): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException("Vous devez être administrateur pour supprimer un message");
		$forum = ForumModel::findOne($query["id"]);
		if (!$forum)
			throw new NotFoundException("Le message n'existe pas");
		$forum->remove();
		return [];
	}
}
