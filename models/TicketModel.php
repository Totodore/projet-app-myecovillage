<?php
namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

class TicketModel extends BaseModel {

	#[PrimaryColumn()]
	public int $id;

	#[Column()]
	public string $title;

	#[Column(type: "TEXT")]
	public string $question;

	#[Column(type: "TEXT")]
	public ?string $answer;

	#[Column()]
	public int $authorid;

	#[Column()]
	public ?int $adminid;

	#[Column()]
	public DateTime $date;

	#[Column(default: false)]
	public bool $open;

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->authorid);
	}

	public function getAdmin(): UserModel {
		return UserModel::findOne($this->adminid);
	}
}