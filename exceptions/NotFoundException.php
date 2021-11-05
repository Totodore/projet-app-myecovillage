<?php
namespace Project\Exceptions;

class NotFoundException extends HttpException
{
	public function __construct(string $message = 'Not Found', int $code = 404, \Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}