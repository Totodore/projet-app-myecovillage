<?php 

namespace Project\Core\Attributes\Http;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
final class Post
{
	public function __construct(?string $route) {

	}
	public const METHOD = 'POST';
}