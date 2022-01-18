<?php

namespace Project\Controllers\Api;

use Project\Conf;
use Project\Core\Attributes\Http\JsonController;
use Project\Core\Attributes\Http\Post;
use Project\Core\Attributes\Http\VerifyRequest;
use Project\Core\BaseController;
use Project\Exceptions\ForbiddenException;
use Project\Exceptions\NotFoundException;
use Project\JWT;
use Project\Models\UserModel;

#[JsonController('api')]
class ContactController extends BaseController {

	#[Post('/contactus')]
	#[VerifyRequest(["prénom", "nom", "email", "objet", "message"])]
	public function contactus(array $query): array {
	$this->sendMail(Conf::MAIL_USER,$query["objet"], $query["message"]);
    return [];
    }
}




