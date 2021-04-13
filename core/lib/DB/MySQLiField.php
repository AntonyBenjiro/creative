<?php


namespace Core\DB;


use Core\Entity\Field;

abstract class MySQLiField extends Field
{




	protected static function getNamespace(){
		return __NAMESPACE__.'\\MySQLi\\Field\\';
	}

	/**
	 * @var bool
	 */
	protected $isNullable=false;

	/**
	 * @var bool
	 */
	protected $isAutoincrement=false;

	/**
	 * @var bool
	 */
	protected $isPK=false;


	protected function __construct(array $fieldDesc){
		$this->isNullable=isset($fieldDesc['nullable'])?$fieldDesc['nullable']:false;
		$this->isPK=isset($fieldDesc['primary'])?$fieldDesc['primary']:false;
		$this->isAutoincrement=isset($fieldDesc['auto_increment'])?$fieldDesc['auto_increment']:false;
		$this->defaultValue=isset($fieldDesc['defaultValue'])?$fieldDesc['defaultValue']:'';
	}

	public function isRequired(){
		return $this->isPK||parent::isRequired();
	}

	public function getSQLColumnDefinition(){
		return $this->getDbType()
			.($this->isNullable?'':' NOT ').' NULL '
			.(!$this->defaultValue?'':' DEFAULT '.$this->defaultValue)
			.(!$this->isAutoincrement?'':' AUTO_INCREMENT ')
			.(!$this->isPK?'':' PRIMARY KEY ');
	}

	/**
	 * @return bool
	 */
	public function isPrimaryKey(){
		return $this->isPK;
	}
}