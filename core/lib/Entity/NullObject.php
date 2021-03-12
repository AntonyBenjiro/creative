<?php


namespace Core\Entity;


use Core\IFace\iEntity;

class NullObject implements iEntity
{

	public function get($value){
		return '';
	}
}