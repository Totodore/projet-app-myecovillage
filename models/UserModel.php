<?php

namespace Project\Models;
use Project\Core\BaseModel;

/**
 * Model for the users table
 */
class UserModel extends BaseModel
{

	public int $m_id;
	public string $m_name;
	public string $m_firstname;
	public int $m_birthdate;
	public int $m_height;
	public int $m_weight;
	public string $m_password;
	public string $m_email;
	public bool $m_isAdmin = false;

	public function __construct()
	{
		parent::__construct();
		$this->m_isAdmin = false;
	}
}
