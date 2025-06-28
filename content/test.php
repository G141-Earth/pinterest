<?php

include_once '../source/php/file.php';
include_once '../source/php/folder.php';
include_once '../source/php/path.php';
include_once '../source/php/leaf.php';

$fun = function($a,$b) { return $a<$b; };
$funLeaf = function($a,$b)
{
	$A = strcmp($a->getMime(), "directory") == 0 ? 0 : 1;
	$B = strcmp($b->getMime(), "directory") == 0 ? 0 : 1;
	if($A==$B)
	{return strcmp($b->getName(), $a->getName())>0;}
	return $A<$B;
	
};

$x = [5,10,20,40,90,0,-20,-1];
quickSort($x,0, count($x)-1, $fun);
var_dump($x);
function write($value, $x=false)
{
	var_dump($value);
	$X = is_bool($x) ? $x : false;
	if ($X)
	{echo "<hr>";}
	else{ echo "<br>"; }
}
$a = new Folder('../libary/folder',2);
echo "<hr>";
//$b = new File('../../libary/856a089c5a669d8d41adbe4f571dff3b.webp',3);
$b = new File('../libary/folder/Budapest Park Gaga.pdf',2);
//$b = new File('../../libary/collection/er',3);
write($a->getRelativePath()->getObject());
write($a->getAbsolutePath()->getObject());
write($a->getName()->getObject(), true);
write($a,true);
write($b->getRelativePath()->getObject());
write($b->getAbsolutePath()->getObject());
write($b->getName()->getObject(),true);
write($b,true);
write($a->read(),true);
write(leaf::val());
leaf::add('a','A');
leaf::add('b','A');
leaf::add('b','B');
write(leaf::val(),true);
$c = new leaf('../libary/folder', 'Budapest Park Gaga.pdf');
$d = new leaf('../libary/folder', 'folder');
$e = new leaf('../libary/folder', 'c');
$f = new leaf('../libary/folder', 'image.png');
$g = new leaf('../libary/folder', 'b');
$h = new leaf('../libary/folder', 'a');
$A = [$c,$d,$e,$f,$g,$h];
write($A,true);
quickSort($A,0, count($A)-1, $funLeaf);
foreach ($A as $key => $value) {
	write($value->getMime().">".$value->getName());
}
write($A,true);
?>