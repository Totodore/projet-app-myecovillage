<?php

namespace Project\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
final class JsonController
{
	public function __construct(?string $baseRoute)
	{
	}
}