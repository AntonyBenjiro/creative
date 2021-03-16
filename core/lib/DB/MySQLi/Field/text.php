<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class text extends MySQLiField
{

	protected function getDbType(){
		return "VARCHAR(255)";
	}
}