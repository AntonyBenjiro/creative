<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class relation extends MySQLiField
{

	protected function getDbType(){
		return 'INT(8)';
	}
}