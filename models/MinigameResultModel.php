<?php

namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

/**
 * Model for the minigame results
 */
class MinigameResultModel extends BaseModel
{

	#[PrimaryColumn()]
	public int $id;

	#[Column()]
	public int $userid;
	#[Column()]
	public int $daymood;
	#[Column()]
	public int $daysleep;
	#[Column()]
	public int $noisedaymood;
	#[Column()]
	public int $noisenightmood;
	#[Column()]
	public int $breathing;
	#[Column()]
	public bool $wentoutside;
	#[Column()]
	public bool $interactiveday;
	#[Column()]
	public bool $sport;
	#[Column(nullable: true)]
	public ?bool $sportindoor;
	#[Column(nullable: true)]
	public ?bool $sportharder;
	#[Column(nullable: true)]
	public ?int $sportduration;
	#[Column()]
	public DateTime $date;

	public function __construct()
	{
		$this->date = new DateTime();
		parent::__construct();
	}

	public function getAuthor(): UserModel
	{
		return UserModel::findOne($this->userid);
	}

	public static function hasWeekStat(string $userid): bool
	{
		foreach (MinigameResultModel::findManyBy("userid", $userid) ?? [] as $result) {
			if ($result->date->format("W") == date("W"))
				return true;
		}
		return false;
	}

	public static function getTodayGame(string $userid): ?MinigameResultModel
	{
		foreach (MinigameResultModel::findManyBy("userid", $userid) ?? [] as $result) {
			if ($result->date->format("Y-m-d") == date("Y-m-d"))
				return $result;
		}
		return null;
	}

	public static function getWeekStat(string $userid): array
	{
		$days = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
		$week = [];
		foreach (MinigameResultModel::findManyBy("userid", $userid) ?? [] as $result) {
			if ($result->date->format("W") != date("W"))
				continue;
			$score = 0;
			$score += $result->daymood;	 //MAX : 5
			if ($result->daysleep > 6 && $result->daysleep < 10) // MAX : 2 (pas + de 12)
				$score++;
			else if ($result->daysleep >= 10)
				$score += 2;
			$score += $result->noisenightmood >= 4 ? 0 : 4 - $result->noisenightmood; // MAX : 3
			$score += $result->noisedaymood > 4 ? 0 : 5 - $result->noisedaymood; // MAX : 4
			$score += $result->breathing / 100;	// MAX : 1
			$score += $result->wentoutside ? 1 : 0;	// MAX : 1
			$score += $result->interactiveday >= 1 ? 2 : 0; 	// MAX : 2
			$score += $result->sport ? 2 : 0; 				// MAX : 2
			$score += !$result->sportindoor ? 1 : 0; // MAX : 1
			$score += max(floor($result->sportduration / 30), 10); 	// MAX : 10 
			$score += !$result->sportharder ? 1 : 0;			// MAX : 1
			$score /= 32;
			$score *= 100;
			$week[intval($result->date->format("w"))] = [intval($result->date->format("w")), $score, $days[intval($result->date->format("w"))]];
		}
		for ($i = 0; $i < 7; $i++) {
			if (!isset($week[$i]))
				$week[$i] = [$i, 0, $days[$i]];
		}
		uasort($week, function ($a, $b) {
			return $a[0] < $b[0] ? -1 : 1;
		});
		return $week;
	}
}
