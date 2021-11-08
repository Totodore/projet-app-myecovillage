<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Get;
use Project\Core\Attributes\JsonController;
use Project\JWT;

#[JsonController('api/users')]
class UserController {

	#[Get('me')]
	public function getMe(): array {
		return JWT::decode($_SERVER['HTTP_AUTHORIZATION'], Conf::JWT_SECRET);
	}
}