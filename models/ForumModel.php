<?php

namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;


class ForumModel extends BaseModel {

	#[PrimaryColumn()]
	public int $id;

	#[Column(type: "TEXT")]
	public string $question;

	#[Column(type: "TEXT")]
	public ?string $answer;

	#[Column()]
	public int $authorid;

	#[Column()]
	public ?int $answerid;
	
	#[Column()]
	public DateTime $date;

	#[Column()]
	public ?DateTime $answerDate;

	public function getAuthor(): UserModel {
		return UserModel::findOne($this->authorid);
	}

	public function getAnswer(): ?UserModel {
		return $this->answerid ? UserModel::findOne($this->answerid) : null;
	}
}