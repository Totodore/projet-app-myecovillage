<?php

namespace Project\Core;
use PDO;
/**
 * Class JsonController
 * Controller that will implements methods for requests that require html responses
 * @package Project\Core
 */
abstract class BaseController
{
	protected PDO $pdo;
	public function __construct() {
		$this->pdo = $GLOBALS['pdo'];
	}
}

/**
 * All the interfaces for the controllers
 * If we want to use an handle a request, we need to implement the corresponding interface
 */
interface IGetController {
	public function verifyGetRequest(array $query): bool;
	public function getHandler(array $query): array;
}
interface IPostController
{
	public function verifyPostRequest(array $query): bool;
	public function postHandler(array $query): array;
}
interface IPatchController
{
	public function verifyPatchRequest(array $query): bool;
	public function patchHandler(array $query): array;
}
interface IPutController
{
	public function verifyPutRequest(array $query): bool;
	public function putHandler(array $query): array;
}
interface IDeleteController
{
	public function verifyDeleteRequest(array $query): bool;
	public function deleteHandler(array $query): array;
}