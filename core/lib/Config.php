<?php


namespace Core;


use Core\IFace\iConfig;

class Config
{

	/**
	 * @var Config
	 */
	private static $_instance;

	private $loadedConfigs=array();

	protected function __construct(){
	}

	public static function get($configName){
		if(!self::$_instance){
			self::$_instance=new self;
		}
		return self::$_instance->getConfig($configName);
	}

	/**
	 * @param string $configName
	 * @return iConfig
	 * @throws \Exception
	 */
	private function getConfig($configName){
		if(!isset($this->loadedConfigs[$configName])){
			$this->loadedConfigs[$configName]=new ConfigElement($configName);
		}
		return $this->loadedConfigs[$configName];
	}
}