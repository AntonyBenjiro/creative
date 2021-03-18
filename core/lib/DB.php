<?php


namespace Core;


use Core\Entity\DataElement;
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
		if(!class_exists($dataManager)){
			throw new \Exception("'{$dataManager}' class not exists");
		}
		$this->dataManager=new $dataManager;
	}

	public static function get(){
		if(!self::$_instance){
			self::$_instance=new self;
		}
		return self::$_instance;
	}

	/**
	 * @param DataElement $dataElement
	 * @return DataElement
	 */
	public function saveElement(DataElement $dataElement){
		return $this->dataManager->saveElement($dataElement);
	}

	public function getData($dataClass,$idKey){
		return $this->dataManager->getData($dataClass,$idKey);
	}

	public function query($sql){
		return $this->dataManager->query($sql);
	}

	public function getDataManager(){
		return $this->dataManager;
	}
}