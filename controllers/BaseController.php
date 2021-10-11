<?php
namespace Project\Controllers;

abstract class BaseController
{
	protected $f3;
	protected $db;

	function beforeroute()
	{
		//TODO: Initialize the database connection
	}

	function afterroute()
	{
		//TODO: Close the database connection && render html or output json
	}
}
