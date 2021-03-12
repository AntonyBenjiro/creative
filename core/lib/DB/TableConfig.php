<?php


namespace Core\DB;


use Core\ConfigElement;

abstract class TableConfig extends ConfigElement
{

	/**
	 * TableConfig constructor.
	 * @param $configName
	 * @param string $configDir
	 * @throws \Exception
	 */
	public function __construct($configName,$configDir=TABLES_CONFIG_DIR){
		parent::__construct($configName,$configDir);
	}
}