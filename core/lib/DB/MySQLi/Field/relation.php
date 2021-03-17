<?php


namespace Core\DB\MySQLi\Field;


use Core\DB;
use Core\DB\MySQLiField;
use Core\Entity\DataElement;
use Core\ToolsString;

class relation extends MySQLiField
{

	/**
	 * @var string
	 */
	private $relationTable;

	public function __construct(array $fieldDesc){
		parent::__construct($fieldDesc);
		$this->relationTable=isset($fieldDesc['relationTable'])?$fieldDesc['relationTable']:'';
	}

	protected function getDbType(){
		return 'INT(8)';
	}

	public function setValue($value){
		if($value instanceof DataElement){
			$value=$value->getPk()->getValue();
		}
		return parent::setValue($value);
	}

	public function getValue(){
		$className=DataElement::getDefaultNamespace().'\\'.ToolsString::snakeToCamel($this->relationTable);
		$data=DB::get()->getDataManager()->getData($this->relationTable,parent::getValue());
		return new $className($data);
	}
}