<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class checkbox extends MySQLiField
{

	protected $defaultValue=0;

	protected function getDbType(){
		return "TINYINT(1)";
	}
}