<?php
use Core\DB;

require 'vendor/autoload.php';
header('Content-type:text/plain');

define('CONFIG_DIR','/app/conf');
define('TABLES_CONFIG_DIR',CONFIG_DIR.'/DB');

DB\MySQLiManager::updateTables();

$conf=new DB\TableConfig('USER');
//print_r($conf);