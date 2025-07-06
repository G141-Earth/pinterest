<?php
include_once '../source/php/search.php';
include_once '../source/php/folder.php';
include_once '../source/php/leaf.php';

$a = new Leaf('../libary','folder');
$b = new Leaf('../libary/folder','image.png');

function write($value, $x=false)
{
	var_dump($value);
	$X = is_bool($x) ? $x : false;
	if ($X)
	{echo "<hr>";}
	else{ echo "<br>"; }
}

write($a);

?>