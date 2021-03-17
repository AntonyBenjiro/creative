<?php

use Core\DB;
use Core\Entity\User;

require 'vendor/autoload.php';
header('Content-type:text/plain');

define('CONFIG_DIR','/app/conf');
define('TABLES_CONFIG_DIR',CONFIG_DIR.'/DB');

DB\MySQLiManager::updateTables();

$user=User::getByPK(1);

if(false){
	$user=new \Core\Entity\User();
	$user->setLOGIN('crazzy501')
		->setNAME('Antony Benjiro')
		->setEMAIL('crazzy501@yandex.ru')
		->setPWD('some_pwd')
		->setACTIVE('1')
		->save();
}

print_r($user);