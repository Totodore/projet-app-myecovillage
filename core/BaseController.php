<?php

namespace Project\Core;

use Exception;
use MailResponseModel;
use Project\Conf;
use Project\Exceptions\HttpException;
use Project\JWT;
use Project\Models\UserModel;
use Project\Utils;

abstract class BaseController {

	private bool $isDynamicRequest = false;
	private ?string $token;

	public function __construct() {
		$this->token = $this->getToken();
	}

	public function redirect(string $location) {
		$root = Conf::get("ROOT_PATH");
		header("Location: /$root$location");
		exit();
	}

	public function isLogged(): bool {
		return $this->token != null && JWT::verify($this->token, Conf::get("JWT_SECRET"));
	}

	public function isAdmin(): bool {
		return $this->isLogged() && $this->getLoggedUser()->isadmin;
	}

	public function loadView(string $view, array $data = []): array {
		$data['isLogged'] = $this->isLogged();
		if ($this->isDynamicRequest)
			return [$view, $data];
		else
			return ["index", $data];
	}

	/**
	 * Send a mail to the given mail address
	 */
	protected function sendMail(string $to, string $subject, string $body): void {
		$query = http_build_query([
			"to" => $to,
			"subject" => $subject,
		]);
		try {
			Utils::file_put_raw_contents("https://mail-rest.dev.scriptis.fr/mail?$query", $body, 'admin', Conf::get('MAIL_PASSWORD'));
		} catch(Exception $e) {
			echo $e->getMessage();
			throw new HttpException("Error while sending mail", 500, $e);
		}
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