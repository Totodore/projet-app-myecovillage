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

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->userid);
	}
}