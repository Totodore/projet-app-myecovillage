<?php

namespace Project\Controllers\Api;

use DateTime;
use Project\Conf;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Models\MinigameResultModel;

#[JsonController('api')]
class MinigameController extends BaseController
{

	#[Post('/minigame')]
	#[VerifyRequest(["daymood", "breathing", "daysleep",	"interactiveday",	"sport",	"noisedaymood",	"noisenightmood",	"wentoutside"])]
	public function addMinigameResult(array $query): array
	{
		if (!$this->isLogged())
			throw new ForbiddenException();
		if ($query["sport"] === true && !isset($query["sportduration"], $query["sportindoor"], $query["sportharder"])) {
			throw new ForbiddenException("sport informations are required when sport is true");
		}
		$minigame = MinigameResultModel::getTodayGame($this->getLoggedUser()->id) ?? new MinigameResultModel();
		foreach ($query as $key => $value) {
			$minigame->{$key} = $value;
		}

		$minigame->date = new DateTime();
		$minigame->userid = $this->getLoggedUser()->id;
		$minigame->save();
		return ["minigame" => $minigame];
	}
}
