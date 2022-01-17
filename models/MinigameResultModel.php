<?php

namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

/**
 * Model for the minigame results
 */
class MinigameResultModel extends BaseModel {

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
	#[Column()]
	public bool $sportindoor;
	#[Column()]
	public bool $sportharder;
	#[Column()]
	public int $sportduration;
	#[Column(default: 'CURRENT_TIMESTAMP')]
	public DateTime $date;

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->userid);
	}

	public static function hasDayStat(string $userid): bool {
		foreach(MinigameResultModel::findManyBy("userid", $userid) ?? [] as $result) {
			if ($result->date->format("Y-m-d") == date("Y-m-d"))
				return true;
		}
		return false;
	}
}