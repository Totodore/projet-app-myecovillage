<?php

namespace Project\Controllers;

use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Models\ForumModel;
use Project\Models\TicketModel;
use Project\Models\UserModel;

#[Controller("admin")]
class AdminController extends BaseController
{

	#[Get("/")]
	public function index(array $query): array
	{
		if (!$this->isAdmin())
			new ForbiddenException();
		return $this->loadView('admin/index', $query);
	}

	#[Get("/index")]
	public function index2(array $query): array
	{
		return $this->index($query);
	}

	#[Get("/ticket")]
	public function ticket(array $query): array
	{
		if (!$this->isAdmin())
			new ForbiddenException();
		$tickets = TicketModel::find() ?? [];
		$openedTickets = [];
		$closedTickets = [];
		foreach ($tickets as $ticket) {
			if ($ticket->open)
				$openedTickets[] = $ticket;
			else
				$closedTickets[] = $ticket;
		}
		return $this->loadView('admin/ticket', ["openedTickets" => $openedTickets, "closedTickets" => $closedTickets]);
	}

	#[Get("/user")]
	public function user(array $query): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException();
		$users = UserModel::find(null, 100);
		foreach ($users as $user) {
			unset($user->password);
		}
		return $this->loadView('admin/user', ["users" => $users]);
	}

	#[Get("/forum")]
	public function forum(array $query): array
	{
		if (!$this->isAdmin())
			throw new ForbiddenException();
		$forums = ForumModel::find();
		return $this->loadView('admin/forum', ["forums" => $forums]);
	}
}
