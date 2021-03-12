<?php


namespace Core\Error;

class MySQLi extends \Exception
{

	public function __construct(\mysqli $mySQLi,$query=''){
		$message="Can't execute query: '{$query}'. DB Error: '{$mySQLi->error}'";
		parent::__construct($message,$mySQLi->errno);
	}
}