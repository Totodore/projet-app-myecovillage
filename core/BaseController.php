<?php

namespace Project\Core;

abstract class BaseController {

	private bool $isDynamicRequest = false;

	protected function loadView(string $view, array $data = []): array {
		if (!$this->isDynamicRequest)
			return [$view, $data];
		else
			return ["index", []];
	}

	public function setDynamicRequest() {
		$this->isDynamicRequest = true;
	}
}