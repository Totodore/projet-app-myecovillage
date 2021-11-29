<?php

namespace Project\Models;

use DateTime;
use Project\Core\Attributes\Orm\PrimaryColumn;
use Project\Core\Attributes\Orm\Column;
use Project\Core\BaseModel;

/**
 * Model for the users table
 */
class UserModel extends BaseModel
{

	#[PrimaryColumn()]
	public ?int $id = null;

	#[Column()]
	public string $name;

	#[Column()]
	public string $firstname;
	
	#[Column()]
	public DateTime $birthdate;
	
	#[Column()]
	public int $height;
	
	#[Column()]
	public int $weight;
	
	#[Column()]
	public string $password;

	#[Column()]
	public string $email;
	
	#[Column(default: false, nullable: false)]
	public bool $isadmin = false;
}
