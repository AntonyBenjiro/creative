<?php


namespace Core\Entity;


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

	/**
	 * @return string
	 */
	public function getFieldName(){
		return $this->fieldName;
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
	 * @return mixed
	 */
	public function getRawValue(){
		return $this->value;
	}

	/**
	 * Value validation method
	 * @todo must be abstracted in future
	 * @param $value
	 * @return $this
	 */
	public function setValue($value){
		$this->value=$value;
		return $this;
	}


	/**
	 * @param $fieldName
	 * @param array $fieldDesc
	 * @param null $value
	 * @return Field
	 * @throws \Exception
	 */
	public static function initField($fieldName,array $fieldDesc,$value=null){
		$fieldClass=static::getNamespace().$fieldDesc['type'];
		if(!class_exists($fieldClass)){
			throw new \Exception("This field type not declared: '{$fieldDesc['type']}'");
		}
		/** @var Field $field */
		$field=new $fieldClass($fieldDesc);
		$field->fieldName=$fieldName;
		$field->value=$value;
		return $field;
	}
}