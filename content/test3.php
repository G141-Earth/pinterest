<?php
include_once '../source/php/database.php';
include_once '../source/php/boolMessage.php';
include_once '../source/php/factory.php';
include_once '../source/php/search.php';

$b = new boolMessage();
$d = new Database();
$p = $d->detect("");
$f = Factory::create('folder','../libary/',2);
$error = !$b->check($f);
if($error)
{echo "0"; die;}
$f = $f->getObject();
$c = $f->getContent();

$lFun = function ($e)
{
	return $e;
};
$eFun = function ($e)
{
	$name = $e->getName();
	return $name->getObject();

};
$cmp = function ($a, $b)
{
	return strcmp($a, $b);
};
foreach ($p as $key => $value) {
	$x = searchSortIndex($c, 0, count($c)-1, $value, $lFun, $eFun, $cmp);
	$obj = $x->getObject();
	$index = $obj->index;
	if($x->is_success())
	{
		$p[$key]->fileMaker();
	}
	echo "<hr>";
}


?>