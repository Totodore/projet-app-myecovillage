<?php
namespace Project\Controllers;

use Project\Core\Attributes\Http\Controller;
use Project\Core\Attributes\Http\Get;
use Project\Core\BaseController;

#[Controller('info')]
class InfoController extends BaseController {

	#[Get('/')]
	public function index(): void {
		phpinfo();
	}

	#[Get('/test')]
	public function test(): void {
		$res = $this->sendMail("prevottheodore@gmail.com", "Yolo", "Yolo");
	}
}