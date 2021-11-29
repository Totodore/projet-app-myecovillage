<?php

namespace Project\Core;

abstract class BaseController {

	protected function loadView(string $view, array $data = []): array {
		return [$view, $data];
	}
}