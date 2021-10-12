<?php

namespace Project\Models;

class FaqArticleModel extends BaseModel {

	public int $m_id;
	public string $m_title;
	public string $m_content;
	public int $m_authorId;
	public UserModel $m_author;
}