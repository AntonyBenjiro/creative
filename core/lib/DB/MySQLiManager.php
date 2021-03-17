<?php


namespace Core\DB;


use Core\Config;
use Core\DB;
use Core\Entity\DataElement;
use Core\Error\MySQLi;
use Core\IFace\iDataManager;
use Core\ToolsString;

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
		$this->transactionsON=$this->config->value('transactions')?true:false;
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
	 * @param DataElement $element
	 * @return DataElement
	 * @throws MySQLi
	 * @throws \Exception
	 */
	public function createElement(DataElement $element){
		$keys=$values=array();
		foreach($element->getValues() as $field){
			$keys[]=$field->getFieldName();
			$values[]=$field->getRawValue();
		}
		$columns=implode('`,`',$keys);
		$values=implode("','",$values);
		$q="INSERT INTO `{$element->dataClass()}` (`{$columns}`) VALUES('{$values}')";
		if(!$this->query($q)){
			throw new MySQLi($this->mysqli,$q);
		}
		$className=DataElement::getDefaultNamespace().'\\'.ToolsString::snakeToCamel($element->dataClass());
		return new $className($this->getData($element->dataClass(),$this->mysqli->insert_id));
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

	public static function updateTables(){
		$dir=scandir($_SERVER['DOCUMENT_ROOT'].TABLES_CONFIG_DIR);
		foreach($dir as $file){
			if(is_file($_SERVER['DOCUMENT_ROOT'].TABLES_CONFIG_DIR.'/'.$file)&&preg_match('/\.json$/',$file)){
				$conf=new TableConfig($_SERVER['DOCUMENT_ROOT'].TABLES_CONFIG_DIR.'/'.basename($file,'.json'));
				self::createTable($conf);
				self::updateIndex($conf);
			}
		}
	}

	private static function updateIndex(TableConfig $config){
		$db=DB::get();
		$indexes=$config->value('indexes');
		if($indexes)
			foreach($indexes as $indexName=>$indexDesc){
				$result=$db->query("SHOW INDEX FROM {$config->value('tableName')} WHERE Key_name='{$indexName}'");
				if(!$result->num_rows){
					$d=$fieldsDescStr='';
					foreach($indexDesc['fields'] as $fieldName=>$fieldDesc){
						$fieldsDescStr.=$d.$fieldName
							.(isset($fieldDesc['length'])?" ({$fieldDesc['length']})":'');
						$d=',';
					}
					$sql="CREATE ".($indexDesc['type']=='unique'?'UNIQUE':'')
						." INDEX {$indexName} ON {$config->value('tableName')} ({$fieldsDescStr})";
					return $db->query($sql);
				}
				return true;
			}
		return false;
	}

	public static function initField($fieldName,array $fieldDesc,$value=null){
		return MySQLiField::initField($fieldName,$fieldDesc,$value);
	}

	private static function createTable(TableConfig $config,$ifNotExists=true){
		$sql="CREATE TABLE ".($ifNotExists?'IF NOT EXISTS':'')." `{$config->value('tableName')}`";
		$fields=$d='';
		$pk=false;
		foreach($config->value('fields') as $fieldName=>$fieldDesc){
			if(isset($fieldDesc['primary'])&&$fieldDesc['primary']){
				$pk=MySQLiField::initField($fieldName,$fieldDesc);
			}
		}
		if(!$pk){
			$fieldName=$config->value('tableName').'_ID';
			$fieldDesc=array(
				'primary'=>true,
				'type'=>'integer',
				'auto_increment'=>true,
				'nullable'=>false
			);
			$pk=MySQLiField::initField($fieldName,$fieldDesc);
		}
		$fields.=$d.PHP_EOL.$pk->getFieldName().' '.$pk->getSQLColumnDefinition();
		$d=',';
		foreach($config->value('fields') as $fieldName=>$fieldDesc){
			try{
				$field=MySQLiField::initField($fieldName,$fieldDesc);
				$fields.=$d.PHP_EOL.$fieldName.' '.$field->getSQLColumnDefinition();
			}catch(\Exception $e){
				var_dump($e->getMessage());
			}
			$d=',';
		}
		$fields=$fields?"({$fields})":'';
		return DB::get()->query($sql.$fields);
	}

	/**
	 * @param $sql
	 * @return bool|\mysqli_result
	 * @throws MySQLi
	 */
	public function query($sql){
		if($this->transactionsON&&!$this->transactionStarted){
			$this->startTransaction();
		}
		$this->lastQueryResult=$this->mysqli->query($sql);
		if(!$this->lastQueryResult){
			throw new MySQLi($this->mysqli,$sql);
		}
		return $this->lastQueryResult;
	}

	/**
	 * @inheritDoc
	 * @throws MySQLi
	 */
	public function saveElement(DataElement $dataElement){
		if(!$dataElement->getPk()){
			return $this->createElement($dataElement);
		}
		return $this->updateElement($dataElement);
	}

	/**
	 * @param DataElement $dataElement
	 * @return DataElement
	 * @throws MySQLi
	 * @throws \Exception
	 */
	public function updateElement(DataElement $dataElement){
		$set='';
		foreach($dataElement->getValues() as $field){
			$set.="`{$field->getFieldName()}`='{$field->getRawValue()}'";
		}
		$q=<<<SQL
UPDATE `{$dataElement->dataClass()}`
SET {$set}
WHERE `{$dataElement->dataClass()}_ID`={$dataElement->getPk()->getValue()}
SQL;
		if(!$this->query($q)){
			throw new MySQLi($this->mysqli,$q);
		}
		return $dataElement;
	}
}