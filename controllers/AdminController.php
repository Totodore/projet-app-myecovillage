<?php

namespace Project\Controllers;

use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Models\TicketModel;

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

}
