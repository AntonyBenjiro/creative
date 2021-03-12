<?php


namespace Core\Entity;


use Core\DB;
use Core\IFace\iEntity;
use Core\ToolsString;

abstract class DataElement implements iEntity
{
	private $properties=array();

	public function __construct(...$properties){
		foreach($properties as $k=>$v){
			$this->properties[$k]=$v;
		}
	}

	/**
	 * @return string
	 * @throws \Exception
	 */
	private function dataClass(){
		return strtoupper(ToolsString::camelToSnake(basename(self::class)));
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function get($value){
		return $this->properties[$value]?:'';
	}

	/**
	 * @throws \Exception
	 */
	public function save(){
		DB::get()->saveData($this->dataClass(),$this->properties);
	}
}