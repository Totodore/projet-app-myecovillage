<?php 

namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

/**
 * model for the heart beat
 */
class HeartBeatModel extends BaseModel {

	#[PrimaryColumn()]
	public int $id;
	#[Column()]
	public int $userId;
	#[Column()]
	public int $heartBeat;
	#[Column()]
	public DateTime $date;
}