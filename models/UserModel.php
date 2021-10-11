<?php

namespace Project\Models;

class UserModel extends BaseModel
{

	public int $m_id;
	public string $m_username;
	public string $m_password;
	public string $m_email;
	public bool $m_isAdmin = false;
}
