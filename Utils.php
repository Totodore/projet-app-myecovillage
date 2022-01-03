<?php

namespace Project;

use Project\Models\UserModel;

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

/**
 * This class is used to encode and decode jwt tokens
 * It implements the JSON Web Token standard: https://jwt.io/introduction
 */
class JWT
{
	public static function encode(object|string|array $payload, string $secret): string
	{
		if (is_object($payload)) {
			$payload = json_encode(get_object_vars($payload));
		} else if (is_array($payload)) {
			$payload = json_encode($payload);
		} else
			$payload = (string)$payload;
		$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
		$header = base64_encode($header);
		$payload = base64_encode($payload);
		$signature = hash_hmac('sha256', $header . '.' . $payload, $secret, true);
		$signature = base64_encode($signature);
		return trim($header, '=') . '.' . trim($payload, '=') . '.' . trim($signature, '=');
	}

	public static function decode(string $token): object
	{
		$parts = explode('.', $token);
		$header = $parts[0];
		$payload = $parts[1];
		$signature = $parts[2];

		$header = base64_decode($header);
		$payload = base64_decode($payload);
		$signature = base64_decode($signature);

		return json_decode($payload);
	}

	public static function verify(string $token, string $secret): bool {
		$parts = explode('.', $token);
		$header = $parts[0];
		$payload = $parts[1];
		$signature = $parts[2];

		$header = base64_decode($header);
		$payload = base64_decode($payload);
		$signature = base64_decode($signature);

		return $signature !== hash_hmac('sha256', $header . '.' . $payload, $secret, true);
	}
}
