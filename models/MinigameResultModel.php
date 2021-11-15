<?php

namespace Project\Models;

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
	public int $userId;
	#[Column()]
	public int $dayMood;
	#[Column()]
	public int $daySleep;
	#[Column()]
	public int $noiseDayMood;
	#[Column()]
	public int $noiseNightMood;
	#[Column()]
	public int $breathing;
	#[Column()]
	public bool $wentOutside;
	#[Column()]
	public bool $interactiveDay;
	#[Column()]
	public bool $sport;
	#[Column()]
	public bool $sportIndoor;
	#[Column()]
	public bool $sportHarder;
	#[Column()]
	public int $sportDuration;

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->userId);
	}
}