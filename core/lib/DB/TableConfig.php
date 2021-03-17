<?php


namespace Core\DB;


use Core\ConfigElement;

class TableConfig extends ConfigElement
{

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