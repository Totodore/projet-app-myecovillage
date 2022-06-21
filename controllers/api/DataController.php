<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\BaseController;
use Project\Core\Attributes\Http\Get;
use Project\Core\Attributes\Http\JsonController;

#[JsonController('api/data')]
class DataController extends BaseController
{

	#[Get('/micro')]
	public function getMicro(array $array): array
	{
		$data = file_get_contents(Conf::DATA_URL);
		$data = substr(substr($data, -23), 0, 2);
		return [
			"mic" => $data
		];
	}
}
