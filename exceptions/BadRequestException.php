<?php
namespace Project\Exceptions;

class BadRequestException extends HttpException
{
	public function __construct(string $message = 'Bad Request', int $code = 400, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}