<?php


namespace Core\DB;


use Core\ConfigElement;

class TableConfig extends ConfigElement
{

	/**
	 * TableConfig constructor.
	 * @param $configName
	 * @param string $configDir
	 * @throws \Exception
	 */
	public function __construct($configName,$configDir=TABLES_CONFIG_DIR){
		parent::__construct($configName,$configDir);
	}

	public function getIndexDesc(){
		$ar=array();
		foreach($this->values as $k=>$v){
			if(strpos($k,'INDEX_')===0){
				$ar[str_replace('INDEX_','',$k)]=$v;
			}
		}
		return $ar;
	}
}