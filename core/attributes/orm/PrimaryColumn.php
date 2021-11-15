<?php

namespace Project\Core\Attributes\Orm;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class PrimaryColumn {
	public function __construct($autoIncrement = true) {
	}
}
