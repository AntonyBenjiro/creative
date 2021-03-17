<?php


namespace Core\DB\MySQLi\Field;


use Core\DB\MySQLiField;

class datetime extends MySQLiField
{

	const FORMAT_DB='Y-m-d H:i:sP';

	protected function getDbType(){
		return 'DATETIME';
	}

	public function setValue($value){
		if($value instanceof \DateTime){
			$value=$value->format(self::FORMAT_DB);
		}
		return parent::setValue($value);
	}

	/**
	 * @return \DateTime
	 * @throws \Exception
	 */
	public function getValue(){
		$r=\DateTime::createFromFormat(self::FORMAT_DB,parent::getValue());
		if(!($r instanceof \DateTime)){
			throw new \Exception("Can't read datetime data");
		}
		return $r;
	}
}