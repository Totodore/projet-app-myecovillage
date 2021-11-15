<?php

namespace Project\Core\Attributes\Http;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class Controller
{
	public function __construct(?string $baseRoute)
	{
	}
}