<?php
include_once '../source/php/search.php';
include_once '../source/php/file.php';
include_once '../source/php/folder.php';
include_once '../source/php/leaf-2.php';
include_once '../source/php/intMessage.php';

function write($value, $x=false)
{
	var_dump($value);
	$X = is_bool($x) ? $x : false;
	if ($X)
	{echo "<hr>";}
	else{ echo "<br>"; }
}

$a = new Folder('../libary/folder',2);
$b = new File('../libary/folder/image.png',2);
$c = new File('../libary/folder/html.html',2);
$a->read();
write($a, true);
write($b, true);
write($c, true);

?>