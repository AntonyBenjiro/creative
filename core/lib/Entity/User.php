<?php


namespace Core\Entity;

use Core\DB\MySQLi\Field\password;

/**
 * Class User
 * @package Core\Entity
 * @method string getLOGIN()
 * @method User setLOGIN(string $value)
 * @method string getEMAIL()
 * @method User setEMAIL(string $value)
 * @method string getNAME()
 * @method User setNAME(string $value)
 * @method integer getACTIVE()
 * @method User setACTIVE(string $value)
 * @method password getPWD()
 * @method User setPWD(string $value)
 */
class User extends DataElement
{

	public function isActive(){
		return ($this->get('ACTIVE')===1)?true:false;
	}
}