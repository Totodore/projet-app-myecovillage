<?php

namespace Project\Controllers;
use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;

#[Controller]
class AdminController {
	#[Get("/admin")]
	public function index(array $query): array {
		print_r($query);
		return ["admin", $query];
	}
}