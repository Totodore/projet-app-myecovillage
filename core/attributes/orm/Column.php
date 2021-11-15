<?php 

namespace Project\Core\Attributes\Orm;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Column {

	public function __construct(?string $type, $default = null, bool $nullable = false) {
	}
}
