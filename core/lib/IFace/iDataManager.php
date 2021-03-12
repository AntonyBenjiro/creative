<?php


namespace Core\IFace;


interface iDataManager
{
	/**
	 * @param $dataClass
	 * @param array $properties
	 * @return bool
	 */
	public function saveData($dataClass,array $properties);
	public function commit();
	public function startTransaction();
	public function revertTransaction();
}