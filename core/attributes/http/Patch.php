<?php

namespace Project\Core\Attributes\Http;

use Attribute;


#[Attribute(Attribute::TARGET_METHOD)]
final class Patch
{
	public function __construct(?string $route) {

	}
	public const METHOD = 'PATCH';
}