<?php


namespace Core\IFace;


use Core\Entity\DataElement;
use Core\Entity\Field;
use Core\Entity\FieldsCollection;

interface iDataManager
{

	/**
	 * @param DataElement $dataElement
	 * @return DataElement
	 */
	public function saveElement(DataElement $dataElement);
	/**
	 * @param DataElement $dataElement
	 * @return DataElement
	 */
	public function updateElement(DataElement $dataElement);
	/**
	 * @param DataElement $dataElement
	 * @return DataElement
	 */
	public function createElement(DataElement $dataElement);

	/**
	 * @param string $dataClass
	 * @param $idKey
	 * @return array
	 */
	public function getData($dataClass,$idKey);

	/**
	 * @param string $fieldName
	 * @param array $fieldDesc
	 * @param null $value
	 * @return Field
	 */
	public static function initField($fieldName, array $fieldDesc,$value=null);

	public function commit();
	public function startTransaction();
	public function revertTransaction();
	public function __destruct();
}