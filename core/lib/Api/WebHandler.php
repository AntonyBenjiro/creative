<?php


namespace Core\Api;


use Core\IFace\iWebApi;
use Core\Request;

abstract class WebHandler implements iWebApi
{

	/**
	 * @var Request
	 */
	protected $request;

	public function __construct(Request $request){
		$this->request=$request;
	}
}