<?php

namespace Project\Models;

use Project\Core\Attributes\Orm\Column;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\BaseModel;

/**
 * Model for FAQ articles
 */
class FaqArticleModel extends BaseModel {

	#[PrimaryColumn()]
	public int $id;

	#[Column()]
	public string $title;
	#[Column(type: "TEXT")]
	public string $content;
	#[Column()]
	public int $authorId;
}