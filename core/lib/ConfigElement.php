<?php


namespace Core;


use Core\IFace\iConfig;

class ConfigElement implements iConfig
{

	protected $values=array();
	private $configName;

	public function __construct($configName,$configDir=CONFIG_DIR){
		$configPath=$_SERVER['DOCUMENT_ROOT'].$configDir.'/'.$configName.'.ini';
		if(!($values=parse_ini_file($configPath,true))){
			throw new \Exception("Can't read values from '{$configPath}'");
		}
		$this->values=$values;
		$this->configName=$configName;
	}

	public function value($valueName){
		return isset($this->values[$valueName])?$this->values[$valueName]:'';
	}
}