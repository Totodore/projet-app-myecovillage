<?php

namespace Project\Controllers;

use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;
use Project\JWT;
use Project\Conf;
use Project\Exceptions\BadRequestException;
use Project\Exceptions\ForbiddenException;
use Project\Exceptions\HttpException;
use Project\Models\MinigameResultModel;
use Project\Models\TicketModel;
use Project\Models\UserModel;

#[Controller]
class IndexController extends BaseController
{

	#[Get('/')]
	public function index(array $query): array
	{
		return $this->loadView('index', ["MAPS_API_KEY" => Conf::MAPS_API_KEY]);
	}

	#[Get('/home')]
	public function home(array $query): array
	{
		if (!$this->isLogged())
			throw new ForbiddenException();
		$user = $this->getLoggedUser();
		$hasWeekStat = MinigameResultModel::hasWeekStat($user->id);
		$dataStat = MinigameResultModel::getWeekStat($user->id);
		return $this->loadView('home', ["user" => $user, "hasWeekStat" => $hasWeekStat, "dataStat" => $dataStat]);
	}

	#[Get('/signin')]
	public function signin(array $query): array
	{
		return $this->loadView('signin', $query);
	}

	#[Get('/signup')]
	public function signup(array $query): array
	{
		return $this->loadView('signup', $query);
	}
	#[Get('/faq')]
	public function faq(array $query): array
	{
		return $this->loadView('faq', $query);
	}

	#[Get('/contactus')]
	public function contactus(array $query): array
	{
		if ($this->isLogged())
			$user = $this->getLoggedUser();
		else 
			$user = NULL;
		return $this->loadView('contactus', ["user" => $user]);
	}

	#[Get('/account')]
	public function account(array $query): array
	{
		if (!$this->isLogged())
			$this->redirect("/");
		$user = $this->getLoggedUser();
		return $this->loadView('account', ["user" => $user, "personal" => true]);
	}

	#[Get('/account/edit')]
	public function account_edit(array $query): array
	{
		if (!$this->isLogged())
			$this->redirect("/");
		$user = $this->getLoggedUser();
		return $this->loadView('account_edit', ["usered" => $user]);
	}

	#[Get('/cgu')]
	public function cgu(array $query): array
	{
		return $this->loadView('cgu', $query);
	}
	#[Get('/forum')]
	public function forum(array $query): array
	{
		return $this->loadView('forum', $query);
	}

	#[Get('/user')]
	public function user(array $query): array
	{
		if (!$this->isLogged())
			throw new ForbiddenException();
		if (!isset($query['id']))
			throw new BadRequestException();
		$user = UserModel::findOne($query['id']);
		return $this->loadView('account', ["user" => $user, "personal" => false]);
	}
	
	#[Get('/ticket')]
	public function ticket(array $query): array {
		if (!$this->isLogged())
			$this->redirect("/");
		$tickets = TicketModel::findManyBy('authorId', $this->getLoggedUser()->id) ?? [];
		$openedTickets = [];
		$closedTickets = [];
		foreach ($tickets as $ticket) {
			if ($ticket->open)
				$openedTickets[] = $ticket;
			else
				$closedTickets[] = $ticket;
		}
		return $this->loadView('ticket', ["openedTickets" => $openedTickets, "closedTickets" => $closedTickets]);
	}
	#[Get('/minigame')]
	public function minigame(array $query): array
	{
		return $this->loadView('minigame', $query);
	}
}
