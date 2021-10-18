<?php
namespace Project\Models;

class AdminMessageModel extends BaseModel {

	public int $m_id;
	public string $m_content;
	public bool $m_opened;
	public int $m_userId;
	public int $m_date;
}