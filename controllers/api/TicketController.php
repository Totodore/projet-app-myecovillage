<?php

namespace Project\Controllers\Api;

use DateTime;
use Project\Conf;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\Put;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Models\TicketModel;

#[JsonController('api/ticket')]
class TicketController extends BaseController {

	#[Get('/all')]
	public function getAll() {
		if (!$this->isAdmin())
			throw new ForbiddenException("You are not allowed to access this page");
	}

	#[Get('/personal')]
	public function getOne() {
		if (!$this->isLogged())
			throw new ForbiddenException("You are not allowed to access this page");

		$user = $this->getLoggedUser();
		$ticket = TicketModel::findBy('authorId', $user->id);
		if ($ticket == null)
			return [];
		return $ticket;
	}

	#[Post('/create')]
	#[VerifyRequest(['title', 'question'])]
	public function createTicket($request) {
		if (!$this->isLogged())
			throw new ForbiddenException("You are not allowed to access this page");

		$user = $this->getLoggedUser();
		$ticket = TicketModel::create([
			'title' => $request["title"],
			'question' => $request["question"],
			'date' => (new DateTime())->format('Y-m-d H:i:s'),
			'open' => true,
		]);
		$ticket->authorid = $user->id;
		$ticket->save();

		$this->sendMail($user->email, "Votre ticket a bien été créé", "Votre ticket intitulé '$ticket->title' a bien été créé");
		$this->sendMail(Conf::get('MAIL_USER'), "Un nouveau ticket a été créé", "Un nouveau ticket a été créé par". $user->getFullName());
		return $ticket;
	}

	#[Put('/answer')]
	#[VerifyRequest(['id', 'answer'])]
	public function answerTicket($request) {
		if (!$this->isAdmin())
			throw new ForbiddenException("You are not allowed to access this page");

		$user = $this->getLoggedUser();
		$ticket = TicketModel::findOne($request["id"]);
		if ($ticket == null)
			throw new ForbiddenException("You are not allowed to access this page");

		$ticket->answer = $request["answer"];
		$ticket->adminid = $user->id;
		$ticket->open = false;
		$ticket->save();

		$this->sendMail($user->email, "Votre ticket a bien été répondu", "Votre ticket intitulé '$ticket->title' a bien été répondu");
		return $ticket;
	}
}