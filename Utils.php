<?php

namespace Project;

class Utils
{

	/**
	 * Little helper function to detect if the given param is json
	 */
	public static function isJson(string $str)
	{
		json_decode($str);
		return json_last_error() === JSON_ERROR_NONE;
	}
}
