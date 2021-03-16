<?php


namespace Core\Entity;


use Core\IFace\iEntity;

abstract class Field
{

	private $fieldName;

	private $fieldDesc=array();

	protected $value;

	/**
	 * @var bool
	 */
	protected $required=false;

	/**
	 * @var string
	 */
	protected $defaultValue='';

	protected function __construct(array $fieldDesc){
	}

	/**
	 * @return bool
	 */
	public function isRequired(){
		return $this->required?true:false;
	}

	abstract protected function getDbType();
	abstract public function getSQLColumnDefinition();
	abstract protected static function getNamespace();


	/**
	 * @return string|number
	 */
	public function getValue(){
		return $this->value;
	}


	/**
	 * @param $fieldName
	 * @param array $fieldDesc
	 * @return Field
	 * @throws \Exception
	 */
	public static function initField($fieldName,array $fieldDesc){
		$fieldClass=static::getNamespace().$fieldDesc['type'];
		if(!class_exists($fieldClass)){
			throw new \Exception("This field type not declared: '{$fieldDesc['type']}'");
		}
		/** @var Field $field */
		$field=new $fieldClass($fieldDesc);
		$field->fieldName=$fieldName;
		return $field;
	}
}