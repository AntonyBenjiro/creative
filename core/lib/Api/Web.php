<?php


namespace Core\Api;


use Core\Api;
use Core\IFace\iWebApi;
use Core\Request;

class Web extends Api
{
	/** @var Request */
	private $request;
	/**
	 * @var string
	 */
	private $method;
	/**
	 * @var string
	 */
	private $class;

	/**
	 * WebApi constructor.
	 */
	public function __construct(){
		$this->request=Request::get();
		$this->class=$this->request->value('class');
		$this->method=$this->request->value('method');
	}

	/** @return string */
	protected function run_body(){
		$return=array(
			'result'=>'',
			'error'=>array()
		);
		try{
			$this->error_checking();
			/** @var iWebApi $webApi */
			$webApi=new $this->class($this->request);
			$result=$webApi->{$this->method}();
			$return['result']=$result?:'ok';
		}catch(\Exception $e){
			$return=array(
				'error'=>array(
					'message'=>$e->getMessage(),
					'code'=>$e->getCode(),
					'file'=>basename($e->getFile()),
					'line'=>$e->getLine()
			));
		}
		return json_encode($return);
	}

	/**
	 * performs data validation for api method ifaces
	 * @throws \Exception
	 */
	private function error_checking(){
		if(!$this->class){
			throw new \Exception('Class not defined');
		}
		if(!class_exists($this->class)){
			throw new \Exception("Class '{$this->class}' not exists");
		}
		if(!$this->method){
			throw new \Exception('Method not defined');
		}
		if(!method_exists($this->class,$this->method)){
			throw new \Exception("Method '{$this->class}::{$this->method}' not exists");
		}
	}
}