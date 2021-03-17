<?php

use Core\Config;
use Core\DB;

require 'vendor/autoload.php';
header('Content-type:text/plain');

define('CONFIG_DIR','/app/conf');
define('TABLES_CONFIG_DIR',CONFIG_DIR.'/DB');

//print_r($conf);