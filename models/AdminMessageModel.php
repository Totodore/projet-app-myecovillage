<?php
namespace Project\Models;

use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

/**
 * Model for admin messages
 */

class AdminMessageModel extends BaseModel {

	#[PrimaryColumn()]
	public int $id;
	#[Column(type: "TEXT")]
	public string $content;

	#[Column()]
	public bool $opened;
	#[Column()]
	public int $userId;
	#[Column()]
	public int $date;
}