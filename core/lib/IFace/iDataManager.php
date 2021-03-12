<?php


namespace Core\IFace;


interface iDataManager
{
	/**
	 * @param string $dataClass
	 * @param array $properties
	 * @return bool
	 */
	public function saveData($dataClass,array $properties);

	/**
	 * @param string $dataClass
	 * @param $idKey
	 * @return array
	 */
	public function getData($dataClass,$idKey);
	public function commit();
	public function startTransaction();
	public function revertTransaction();
	public function __destruct();
}