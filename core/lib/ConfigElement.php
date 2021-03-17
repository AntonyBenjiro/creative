<?php


namespace Core;


use Core\IFace\iConfig;

class ConfigElement implements iConfig
{

	protected $values=array();

	/** @var string */
	private $configName;

	public function __construct($configPath){
		$configPath.='.json';
		if(!is_file($configPath)||!preg_match('/(.*?)\/?([a-zA-Z0-9_-]+)\.json$/',$configPath,$m)){
			throw new \Exception("Can't find config file");
		}
		$configName=$m[2];
		if(!($values=json_decode(file_get_contents($configPath),true))){
			throw new \Exception("Can't read values from '{$configName}'");
		}
		$this->values=$values;
		$this->configName=$configName;
	}

	public function value($valueName){
		return isset($this->values[$valueName])?$this->values[$valueName]:'';
	}
}