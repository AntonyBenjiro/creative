<?php


namespace App\Api\Web;


use Core\Api\WebHandler;

class ExampleApiHandler extends WebHandler
{

	public function exampleMethod(){
		$data=$this->request->value('exampleData');
		if($data){
			return true;
		}
		return false;
	}
}