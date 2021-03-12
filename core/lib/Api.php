<?php


namespace Core;


abstract class Api
{

	/** @return string */
	abstract protected function run_body();

	/**
	 * @return string
	 */
	public function run(){
		$return='';
		try{
			$return=$this->run_body();
		}catch(\Exception $e){
			//TODO: implement api errors handling
		}
		return $return;
	}
}