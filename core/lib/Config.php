<?php


namespace Core;


use Core\IFace\iConfig;

class Config
{

	/**
	 * @var Config
	 */
	private static $_instance;

	/** @var ConfigElement[] */
	private $loadedConfigs=array();

	protected function __construct(){
	}

	public static function get($relConfPath){
		if(!self::$_instance){
			self::$_instance=new self;
		}
		return self::$_instance->getConfig($relConfPath);
	}

	/**
	 * @param string $relConfPath
	 * @return iConfig
	 * @throws \Exception
	 */
	private function getConfig($relConfPath){
		if(!isset($this->loadedConfigs[$relConfPath])){
			$this->loadedConfigs[$relConfPath]=new ConfigElement($_SERVER['DOCUMENT_ROOT'].CONFIG_DIR.'/'.$relConfPath);
		}
		return $this->loadedConfigs[$relConfPath];
	}
}