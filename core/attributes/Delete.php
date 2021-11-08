<?php

namespace Project\Core\Attributes;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Delete
{
	public function __construct(?string $route) {

	}
	public const METHOD = 'DELETE';
}
