<?php

namespace Project\Core;

abstract class BaseController {

	private bool $isDynamicRequest = false;

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
}