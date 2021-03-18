<?php


namespace Core\DB;


use Core\ConfigElement;

class TableConfig extends ConfigElement
{

	public function getFields(){
		$fieldsList=&$this->values['fields'];
		if(!isset($fieldsList[$this->values['tableName'].'_ID'])){
			$fieldsList[$this->values['tableName'].'_ID']=array(
				'primary'=>true,
				'type'=>'integer',
				'auto_increment'=>true,
				'nullable'=>false
			);
		}
		return $fieldsList;
	}

	public function value($valueName){
		if($valueName=='fields'){
			return $this->getFields();
		}
		return parent::value($valueName);
	}
}