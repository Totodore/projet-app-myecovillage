<?php
namespace Project\Exceptions;

class ForbiddenException extends HttpException
{
	public function __construct(string $message = 'Access Forbidden', int $code = 403, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}