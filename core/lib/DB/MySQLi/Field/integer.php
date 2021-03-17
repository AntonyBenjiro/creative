<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class integer extends MySQLiField
{

	protected function getDbType(){
		return 'INT(8)';
	}
}