<?php

namespace Project\Core\Attributes\Http;

use Project\Exceptions\ForbiddenException;
use Attribute;
use Project\Conf;
use Project\JWT;

#[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)]
final class AuthGuard
{

	public function __construct()
	{
		if (!$this->isLoggedIn()) {
			http_response_code(403);
			exit();
		}
	}

	private function isLoggedIn(): bool
	{
		$auth = getallheaders()["Authorization"] ?? null;
		if ($auth === null)
			return false;
		try {
			JWT::decode($auth, Conf::JWT_SECRET);
			return true;
		} catch(\Exception $e) {
			return false;
		}
	}
}