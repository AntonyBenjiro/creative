<?php


namespace Core\Entity;

class User extends DataElement
{

	public function isActive(){
		return ($this->get('ACTIVE')===1)?true:false;
	}
}