<?php

namespace Project\Controllers;

abstract class BaseController
{
}
interface IGetController {
	public function verifyGetRequest(array $query): bool;
	public function getHandler(array $query): array;
}
interface IPostController
{
	public function verifyPostRequest(array $query): bool;
	public function postHandler(): array;
}
interface IPatchController
{
	public function verifyPatchRequest(array $query): bool;
	public function patchHandler(): array;
}
interface IPutController
{
	public function verifyPutRequest(array $query): bool;
	public function putHandler(): array;
}
interface IDeleteController
{
	public function verifyDeleteRequest(array $query): bool;
	public function deleteHandler(): array;
}