<?php


namespace Core;


use Core\IFace\iConfig;

abstract class ConfigElement implements iConfig
{

	private $values=array();

	public function __construct($configName,$configDir=CONFIG_DIR){
		$configPath=$configDir.'/'.$configName.'.ini';
		if(!($values=parse_ini_file($configPath))){
			throw new \Exception("Can't read values from '{$configPath}'");
		}
		$this->values=$values;
	}

	public function value($valueName){
		return $this->values[$valueName]?:'';
	}
}