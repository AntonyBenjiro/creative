<?php


namespace Core;


use Core\IFace\iDataManager;

class DB
{

	/**
	 * @var DB
	 */
	private static $_instance;

	/**
	 * @var iDataManager
	 */
	private $dataManager;

	protected function __construct(){
		$dataManager=Config::get('DataManager')->value('class');
		$this->dataManager=new $dataManager;
	}

	public static function get(){
		if(!self::$_instance){
			self::$_instance=new self;
		}
		return self::$_instance;
	}

	/**
	 * @param string $dataClass
	 * @param array $properties
	 * @return bool
	 * @throws \Exception
	 */
	public function saveData($dataClass,array $properties){
		return $this->dataManager->saveData($dataClass,$properties);
	}
}