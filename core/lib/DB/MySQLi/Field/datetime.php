<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class datetime extends MySQLiField
{

	protected function getDbType(){
		return 'DATETIME';
	}
}