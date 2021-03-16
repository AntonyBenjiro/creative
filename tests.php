<?php
require 'vendor/autoload.php';
header('Content-type:text/plain');

//$db=new \MongoDB\Driver\Manager("mongodb://127.0.0.1");

$coll= (new MongoDB\Client("mongodb://127.0.0.1"))->local->bk_subj;

$r=$coll->find([],[
	'projection'=>['id_resolute'=>1,'subjId'=>1]
]);
$c=0;
foreach($r as $item){
	if($item->id_resolute instanceof \MongoDB\Model\BSONArray&&count($item->id_resolute)>0) {
		$newIdResolute=[];
		foreach($item->id_resolute as $k=>$v){
			$newIdResolute[$v]=null;
		}
		$coll->updateOne(['subjId'=>$item->subjId],[
			'$set'=>['id_resolute'=>$newIdResolute]
		]);
	}
	print('.');
	$c++;
	if($c%100===0){
		print($c.PHP_EOL);
	}
}

$r=$coll->find([],[
	'limit'=>5
]);
print_R($r->toArray());