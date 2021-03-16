<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class longtext extends MySQLiField
{

	protected function getDbType(){
		return "TEXT";
	}
}