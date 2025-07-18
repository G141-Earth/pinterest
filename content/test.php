<?php

include_once '../source/php/file.php';
include_once '../source/php/folder.php';
include_once '../source/php/path.php';
include_once '../source/php/leaf.php';
include_once '../source/php/leaf-2.php';

$fun = function($a,$b) { return $a<$b; };
$funLeaf = function($a,$b)
{
	$A = strcmp($a->getMime()->getObject(), "directory") == 0 ? 0 : (str_starts_with($a->getMime()->getObject(), "image") ? 1 : 2);
	$B = strcmp($b->getMime()->getObject(), "directory") == 0 ? 0 : (str_starts_with($b->getMime()->getObject(), "image") ? 1 : 2);
	if($A==$B && $A != 2)
	{return strcmp($b->getName()->getObject(), $a->getName()->getObject())>0;}
	else if($A==$B && $A == 2)
	{return strcmp($b->getMime()->getObject(), $a->getMime()->getObject())>0;}
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
$b = new File('../libary/folder/pdf.pdf',2);
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
write(leaf2::val());
leaf2::add('a','A');
leaf2::add('b','A');
leaf2::add('b','B');
leaf2::add('html','document');
leaf2::add('txt','note');
write(leaf2::val(),true);
$c = new leaf2('../libary/folder/pdf.pdf',2);
$d = new leaf2('../libary/folder/folder',2);
$e = new leaf2('../libary/folder/c',2);
$f = new leaf2('../libary/folder/image.png',2);
$g = new leaf2('../libary/folder/b',2);
$h = new leaf2('../libary/folder/a',2);
$i = new leaf2('../libary/folder/video.mp4',2);
$j = new leaf2('../libary/folder/gif.gif',2);
$k = new File('../libary/folder/html.html',2);
$A = [$c,$d,$e,$f,$g,$h,$i,$j,$k];
write($A,true);
quickSort($A,0, count($A)-1, $funLeaf);
$extentions = leaf2::val();
foreach ($A as $key => $value) {
	$s = explode('/', $value->getMime()->getObject());
	if(isset($s[1]))
	{$s = isset($extentions[$s[1]]) ? $extentions[$s[1]] : $s[1];}
	else{ $s = 'folder'; }
	write($value->getMime()->getObject()."/".$s.">".$value->getName()->getObject());
}
write($A,true);
?>