<?php


namespace Core\DB;


use Core\Config;
use Core\Error\MySQLi;
use Core\IFace\iDataManager;

class MySQLiManager implements iDataManager
{

	/**
	 * @var bool
	 */
	private $transactionsON=false;

	/**
	 * @var bool
	 */
	private $transactionStarted=false;
	/**
	 * @var \Core\IFace\iConfig
	 */
	private $config;
	/**
	 * @var \mysqli
	 */
	private $mysqli;
	/**
	 * @var bool|\mysqli_result
	 */
	private $lastQueryResult;

	public function __construct(){
		$this->config=Config::get('DataManager');
		$this->transactionsON=$this->config->value('transaction')?true:false;
		$this->mysqli=new \mysqli(
			$this->config->value('host'),
			$this->config->value('user'),
			$this->config->value('pwd'),
			$this->config->value('db')
		);
	}

	/**
	 * @param $dataClass
	 * @param $idKey
	 * @return array
	 * @throws \Exception
	 */
	public function getData($dataClass,$idKey){
		$q="SELECT * FROM `{$dataClass}` WHERE `{$dataClass}_ID`='{$idKey}'";
		if(!($result=$this->mysqli->query($q))){
			throw new MySQLi($this->mysqli,$q);
		}
		return $result->fetch_assoc();
	}

	/**
	 * @param $dataClass
	 * @param array $properties
	 * @return bool
	 * @throws \Exception
	 */
	public function saveData($dataClass,array $properties){
		if($this->transactionsON&&!$this->transactionStarted){
			$this->startTransaction();
		}
		$columns=implode('`,`',array_keys($properties));
		$values=implode("','",array_values($properties));
		$q="INSERT INTO `{$dataClass}` (`{$columns}`) VALUES('{$values}')";
		$this->lastQueryResult=$this->mysqli->query($q);
		if(!$this->lastQueryResult){
			$this->revertTransaction();
			throw new MySQLi($this->mysqli,$q);
		}
		return $this->lastQueryResult?true:false;
	}

	public function commit(){
		if($this->transactionStarted){
			$this->mysqli->commit();
		}
		$this->transactionStarted=false;
	}

	public function startTransaction(){
		if(!$this->mysqli->begin_transaction()){
			throw new MySQLi($this->mysqli,'START TRANSACTION');
		}
		$this->transactionStarted=true;
	}

	public function revertTransaction(){
		if($this->transactionStarted){
			$this->mysqli->rollback();
		}
	}

	public function __destruct(){
		if($this->transactionStarted){
			$this->commit();
		}
	}
}