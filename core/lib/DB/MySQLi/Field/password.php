<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class password extends MySQLiField
{

	private $salt='D3R_PAR0L';

	protected function getDbType(){
		return "VARCHAR(255)";
	}

	/**
	 * @todo remove from there to more abstracted entity
	 * @deprecated
	 * @param $string
	 * @return false|string|null
	 */
	protected function encode($string){
		return password_hash($string,PASSWORD_BCRYPT ,array('salt'=>$this->salt));
	}

	/**
	 * @todo remove from there to more abstracted entity
	 * @deprecated
	 * @param $string
	 * @return checkbox
	 */
	public function validate($string){
		return password_verify($string,$this->value);
	}
}