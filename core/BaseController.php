<?php

namespace Project\Core;

use Project\JWT;
use Project\Models\UserModel;

abstract class BaseController {

	private bool $isDynamicRequest = false;
	private ?string $token;

	public function __construct() {
		$this->token = $this->getToken();
	}

	public function isLogged(): bool {
		return $this->token != null;
	}

	protected function loadView(string $view, array $data = []): array {
		if ($this->isDynamicRequest)
			return [$view, $data];
		else
			return ["index", []];
	}

	/**
	 * Send a mail to the given mail address
	 */
	protected function sendMail(string $to, string $subject, string $body): bool {
		return mail($to, $subject, $body);
	}

	public function setDynamicRequest() {
		$this->isDynamicRequest = true;
	}

	public function getLoggedUser(): ?UserModel {
		$id = JWT::decode($this->token)->id;
		return UserModel::findOne($id);
	}

	private function getToken(): ?string {
		$headers = getallheaders();
		if (isset($headers['Authorization']))
			return $headers['Authorization'];
		else
			return null;
	}
}