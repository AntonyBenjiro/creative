<?php


namespace Core;


abstract class ToolsString
{
	public static function camelToSnake($string){
		if(!is_string($string)){
			throw new \Exception("Value not a string: '".gettype($string)."'");
		}

		preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $string, $matches);
		$ret = $matches[0];
		foreach ($ret as &$match) {
			$match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
		}
		return implode('_', $ret);
	}

	public static function removeNamespaceFromClassName($classname){
		$class=explode('\\',$classname);
		return end($class);
	}
}