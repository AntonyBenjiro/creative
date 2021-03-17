<?php


namespace Core\Entity;


class FieldsCollection implements \ArrayAccess,\Countable,\Iterator
{

	/**
	 * @var Field[]
	 */
	private $fields=array();
	private $fieldsIndex=array();
	private $cursor=0;

	/** @var int total number of Field elements */
	private $count=0;

	/**
	 * FieldsCollection constructor.
	 * @param Field[] $fields
	 */
	public function __construct(array $fields=[]){
		$c=0;
		foreach($fields as $field){
			if($field instanceof Field){
				$this->fields[]=$field;
				$this->fieldsIndex[$field->getFieldName()]=$c++;
			}
		}
		$this->count=$c;
	}

	/**
	 * @inheritDoc
	 */
	public function current(){
		return $this->fields[$this->cursor];
	}

	/**
	 * @inheritDoc
	 */
	public function next(){
		$this->cursor++;
	}

	/**
	 * @inheritDoc
	 */
	public function key(){
		return $this->current()->getFieldName();
	}

	/**
	 * @inheritDoc
	 */
	public function valid(){
		return isset($this->fields[$this->cursor]);
	}

	/**
	 * @inheritDoc
	 */
	public function rewind(){
		$this->cursor=0;
	}

	/**
	 * @inheritDoc
	 */
	public function offsetExists($offset){
		return isset($this->fieldsIndex[$offset]);
	}

	/**
	 * @inheritDoc
	 */
	public function offsetGet($offset){
		return $this->fields[$this->fieldsIndex[$offset]];
	}

	/**
	 * @inheritDoc
	 */
	public function offsetSet($offset,$value){
		if(!($value instanceof Field)){
			throw new \Exception("U r adding wrong element to collection");
		}
		if(isset($this->fieldsIndex[$offset])){
			throw new \Exception("Element with that name already in collection");
		}
		$this->fields[]=$value;
		$this->fieldsIndex[$value->getFieldName()]=array_key_last($this->fields);
		$this->count++;
	}

	/**
	 * @inheritDoc
	 */
	public function offsetUnset($offset){
		if(isset($this->fieldsIndex[$offset])){
			$itemPosition=$this->fieldsIndex[$offset];
			if(isset($this->fields[$itemPosition])){
				unset($this->fields[$itemPosition]);
				$this->count--;
			}
			unset($this->fieldsIndex[$offset]);
		}
	}

	/**
	 * @inheritDoc
	 */
	public function count(){
		return $this->count;
	}
}