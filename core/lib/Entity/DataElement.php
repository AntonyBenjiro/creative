<?php


namespace Core\Entity;


use Core\DB;
use Core\IFace\iEntity;
use Core\ToolsString;

abstract class DataElement implements iEntity
{
	/**
	 * @var Field[]|FieldsCollection
	 */
	private $properties;

	/**
	 * @var DB\TableConfig
	 */
	private DB\TableConfig $modelConfig;


	/** @var Field Primary Key */
	private $pk;

	/**
	 * DataElement constructor.
	 * @param array $properties
	 * @throws \Exception
	 */
	public function __construct(array $properties=array()){
		$idKey=$this->dataClass().'_ID';
		$this->modelConfig=new DB\TableConfig($_SERVER['DOCUMENT_ROOT'].TABLES_CONFIG_DIR.'/'.$this->dataClass());
		$this->properties=new FieldsCollection;
		if(isset($properties[$idKey])&&count($properties)===1){
			$properties=DB::get()->getData($this->dataClass(),$properties[$idKey]);
		}
		foreach($properties as $k=>$v){
			$field=DB::get()
				->getDataManager()
				->initField($k,$this->modelConfig->value('fields')[$k],$v);
			if($k==$idKey){
				$this->pk=$field;
			}
			$this->properties[$k]=$field;
		}
	}

	/**
	 * @param $pk
	 * @return DataElement
	 * @throws \Exception
	 */
	public static function getByPK($pk){
		return new static(array(static::dataClass().'_ID'=>$pk));
	}

	public static function getDefaultNamespace(){
		return __NAMESPACE__;
	}

	public function __call($name,$arguments){
		if(preg_match('/^(get|set)([A-Z_]+$)$/',$name,$m)){
			switch($m[1]){
				CASE 'get':
					return $this->properties[$m[2]]->getValue();
				BREAK;
				CASE 'set':
					if(!isset($this->properties[$m[2]])){
						$this->properties[$m[2]]=$this->createField($m[2]);
					}
					$this->properties[$m[2]]->setValue($arguments[0]);
					return $this;
				BREAK;
			}
		}
		throw new \Exception("Unknown method '{$name}'");
	}

	private function createField($name){
		$desc=$this->modelConfig->value('fields')[$name];
		return DB::get()->getDataManager()->initField($name,$desc);
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	public static function dataClass(){
		return strtoupper(ToolsString::camelToSnake(ToolsString::removeNamespaceFromClassName(static::class)));
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function get($value){
		return $this->properties[$value]?:'';
	}

	/**
	 * @return DataElement
	 */
	public function save(){
		return DB::get()->saveElement($this);
	}

	/**
	 * @return Field
	 */
	public function getPk(){
		return $this->pk;
	}

	public function getValues(){
		$values=array();
		if($this->pk){
			$values[$this->pk->getFieldName()]=$this->pk;
		}
		foreach($this->properties as $field){
			$values[$field->getFieldName()]=$field;
		}
		return $values;
	}
}