<?php 

namespace Project\Models;

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
	public int $date;
}