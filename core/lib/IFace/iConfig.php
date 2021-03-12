<?php


namespace Core\IFace;


interface iConfig
{

	/**
	 * iConfig constructor.
	 * @param string $configName
	 */
	public function __construct($configName);

	/**
	 * @param string $valueName
	 * @return string
	 */
	public function value($valueName);
}