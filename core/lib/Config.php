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
	 */
	private function getConfig($configName){
		if(!$this->loadedConfigs[$configName]){
			$this->loadedConfigs[$configName]=new $configName($configName);
		}
		return $this->loadedConfigs[$configName];
	}
}