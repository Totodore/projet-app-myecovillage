<?php

namespace Project\Core;

use Project\Models\UserModel;

class AdminController extends BaseController
{
	public function checkLogin(array $headers): UserModel|bool
	{
		if (!isset($headers['Authorization'])) {
			return false;
		}

		$token = explode(' ', $headers['Authorization']);

		if (count($token) !== 2) {
			return false;
		}

		$token = $token[1];

		// $user = UserModel::findOne();

		if (!$user) {
			return false;
		}

		return $user;
	}
}
