<?php


namespace Core\Entity;


use Core\IFace\iEntity;

abstract class Globals implements iEntity
{

	/**
	 * @var array
	 */
	protected $data;

	/**
	 * array from default globals $_GET|$_POST|$SERVER|etc...
	 * @param array $data
	 */
	public function __construct(array $data){
		$this->data=$data;
	}

	/**
	 * @param $value
	 * @return string
	 */
	public function get($value){
		return isset($this->data[$value])?$this->data[$value]:'';
	}
}